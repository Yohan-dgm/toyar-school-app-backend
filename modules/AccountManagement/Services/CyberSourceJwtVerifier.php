<?php

namespace Modules\AccountManagement\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Verifies CyberSource Unified Checkout result JWTs using RS256.
 *
 * CyberSource signs UC result JWTs (returned by checkout.mount()) with an RSA
 * private key. The corresponding public key is published at:
 *   Sandbox:    GET https://apitest.cybersource.com/flex/v2/public-keys/{kid}
 *   Production: GET https://api.cybersource.com/flex/v2/public-keys/{kid}
 *
 * This endpoint serves keys for BOTH Flex and Unified Checkout result JWTs
 * (confirmed by CyberSource documentation — same key infrastructure).
 *
 * Verification steps (per your requirements):
 *   1. Extract JWT header → read kid and alg
 *   2. Guard: reject if alg is not RS256 (prevents algorithm confusion attacks)
 *   3. Retrieve and cache the JWK from the correct endpoint (per-kid, 1 hour TTL)
 *   4. Verify the RS256 signature using firebase/php-jwt
 *   5. Validate exp (not expired) and iat (not in the future)
 *   6. iss is NOT validated — CyberSource UC result JWTs do not populate this claim
 *      and CyberSource documentation does not specify an expected value for it.
 *      The RS256 signature check is the primary trust mechanism.
 *   7. Return the verified payload as an array — throws on any failure
 *
 * Usage:
 *   $payload = $this->verifier->verify($jwtString);
 *   // $payload is now cryptographically trusted
 */
class CyberSourceJwtVerifier
{
    /** Clock skew tolerance in seconds (handles network delay between UC and backend call). */
    private const LEEWAY_SECONDS = 60;

    /** How long to cache a public key per kid (seconds). */
    private const CACHE_TTL_SECONDS = 3600; // 1 hour

    /** Only RS256 is accepted — reject any other algorithm. */
    private const ALLOWED_ALGORITHM = 'RS256';

    public function __construct()
    {
        // Apply clock skew tolerance globally for this library instance.
        // 60 seconds handles network delays without meaningful security reduction.
        JWT::$leeway = self::LEEWAY_SECONDS;
    }

    /**
     * Verify a CyberSource UC result JWT and return its decoded payload.
     *
     * @param  string $jwt  The raw JWT string returned by checkout.mount()
     * @return array        Decoded and cryptographically verified payload
     *
     * @throws \Exception   On invalid signature, expired token, wrong algorithm,
     *                      or failure to fetch the public key
     */
    public function verify(string $jwt): array
    {
        // ── Step 1: Parse JWT header ───────────────────────────────────────────
        $header = $this->extractHeader($jwt);

        $kid = $header['kid'] ?? null;
        $alg = $header['alg'] ?? null;

        Log::info('CyberSourceJwtVerifier: verifying UC result JWT', [
            'kid' => $kid,
            'alg' => $alg,
        ]);

        if (empty($kid)) {
            throw new \Exception('CyberSource JWT verification failed: missing kid in header');
        }

        // ── Step 2: Algorithm guard ────────────────────────────────────────────
        // Reject anything that is not RS256 to prevent algorithm confusion attacks.
        // (e.g. alg:none, HS256 with attacker-controlled secret)
        if ($alg !== self::ALLOWED_ALGORITHM) {
            Log::warning('CyberSourceJwtVerifier: rejected — unexpected algorithm', [
                'alg_received' => $alg,
                'alg_expected' => self::ALLOWED_ALGORITHM,
            ]);
            throw new \Exception(
                "CyberSource JWT verification failed: algorithm '{$alg}' is not allowed (expected RS256)"
            );
        }

        // ── Step 3: Fetch and cache the JWK ───────────────────────────────────
        // Cache key is per-kid so key rotation works automatically:
        // a new kid in the header → cache miss → fresh fetch from CyberSource.
        $jwks = $this->fetchAndCacheJwk($kid);

        // ── Step 4 + 5: Verify signature and validate exp/iat ─────────────────
        // JWT::decode() with RS256 keys:
        //   - Verifies the RS256 signature (primary security check)
        //   - Validates exp (rejects expired tokens)
        //   - Validates nbf if present
        //   - Respects JWT::$leeway for clock skew
        //   - iat is NOT validated by firebase/php-jwt by default — we check it below
        try {
            $keySet = JWK::parseKeySet($jwks);
            $decoded = JWT::decode($jwt, $keySet);
        } catch (\Firebase\JWT\ExpiredException $e) {
            Log::warning('CyberSourceJwtVerifier: JWT is expired', ['kid' => $kid]);
            throw new \Exception('CyberSource JWT verification failed: token is expired');
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            Log::warning('CyberSourceJwtVerifier: signature verification FAILED — possible forgery attempt', [
                'kid' => $kid,
            ]);
            throw new \Exception('CyberSource JWT verification failed: invalid RS256 signature');
        } catch (\Throwable $e) {
            Log::warning('CyberSourceJwtVerifier: JWT decode error', [
                'kid'   => $kid,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('CyberSource JWT verification failed: ' . $e->getMessage());
        }

        $payload = (array) $decoded;

        // ── Step 5 (cont.): Validate iat ─────────────────────────────────────
        // firebase/php-jwt does not enforce iat. Reject tokens where iat is in
        // the future (with leeway), which would indicate a backdated or forged token.
        $iat = $payload['iat'] ?? null;
        if ($iat !== null && $iat > (time() + self::LEEWAY_SECONDS)) {
            Log::warning('CyberSourceJwtVerifier: iat is in the future', [
                'kid' => $kid,
                'iat' => $iat,
                'now' => time(),
            ]);
            throw new \Exception('CyberSource JWT verification failed: iat is in the future');
        }

        // ── Step 6: iss not validated ─────────────────────────────────────────
        // CyberSource UC result JWTs do not populate the iss claim.
        // CyberSource documentation does not specify an expected issuer value for
        // this token type. Log if present but do not reject if absent.
        $iss = $payload['iss'] ?? null;
        if ($iss !== null) {
            Log::info('CyberSourceJwtVerifier: iss present in UC result JWT', ['iss' => $iss]);
        }

        Log::info('CyberSourceJwtVerifier: JWT signature verified ✓', [
            'kid'    => $kid,
            'status' => $payload['status'] ?? null,
            'id'     => $payload['id']     ?? null,
        ]);

        return $payload;
    }

    // ── Private helpers ────────────────────────────────────────────────────────

    /**
     * Decode and return the JWT header without verifying the signature.
     * Used only to read kid and alg before verification.
     *
     * @throws \Exception if the JWT structure is malformed
     */
    private function extractHeader(string $jwt): array
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) {
            throw new \Exception(
                'CyberSource JWT verification failed: malformed JWT (expected 3 parts, got ' . count($parts) . ')'
            );
        }

        $headerJson = base64_decode(str_pad(strtr($parts[0], '-_', '+/'), (int) ceil(strlen($parts[0]) / 4) * 4, '='));

        if ($headerJson === false) {
            throw new \Exception('CyberSource JWT verification failed: header is not valid base64');
        }

        $header = json_decode($headerJson, true);

        if (!is_array($header)) {
            throw new \Exception('CyberSource JWT verification failed: header is not valid JSON');
        }

        return $header;
    }

    /**
     * Fetch the JWK for the given kid from CyberSource and cache it.
     *
     * Cache key: cybersource_jwk_{kid}
     * TTL:       1 hour (CACHE_TTL_SECONDS)
     *
     * A new kid in a JWT header causes a cache miss, triggering an automatic
     * fresh fetch — this ensures key rotation is handled transparently.
     *
     * @throws \Exception if the fetch fails or the response is not a valid JWK
     */
    private function fetchAndCacheJwk(string $kid): array
    {
        $env     = config('services.cybersource.env', 'test');
        $apiHost = $env === 'production'
            ? 'https://api.cybersource.com'
            : 'https://apitest.cybersource.com';

        $cacheKey = "cybersource_jwk_{$kid}";

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($apiHost, $kid) {
            $url = "{$apiHost}/flex/v2/public-keys/{$kid}";

            Log::info('CyberSourceJwtVerifier: fetching public key from CyberSource', [
                'url' => $url,
                'kid' => $kid,
            ]);

            try {
                $response = Http::timeout(10)->get($url);
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // Preserve the exception type (not a generic \Exception): callers
                // distinguish "couldn't reach CyberSource" (outcome unknown, needs
                // reconciliation) from "JWT is cryptographically invalid" (safe to
                // reject outright). Collapsing this into \Exception would make an
                // infrastructure hiccup indistinguishable from token tampering.
                throw new \Illuminate\Http\Client\ConnectionException(
                    "CyberSource JWT verification: could not fetch public key for kid={$kid} — " . $e->getMessage(),
                    (int) $e->getCode(),
                    $e
                );
            }

            if ($response->failed()) {
                throw new \Exception(
                    "CyberSource JWT verification failed: public key endpoint returned HTTP {$response->status()} for kid={$kid}"
                );
            }

            $jwk = $response->json();

            // JWK::parseKeySet() expects a JWKS (keyset) document with a "keys" array.
            // CyberSource returns a single JWK object — normalise to keyset format.
            if (!isset($jwk['keys'])) {
                $jwk = ['keys' => [$jwk]];
            }

            // firebase/php-jwt v7 requires each key object to have an "alg" field.
            // CyberSource's public key endpoint omits this field from the JWK response.
            // We inject "RS256" here because:
            //   (a) The JWT header already confirmed alg=RS256 before this fetch.
            //   (b) CyberSource exclusively signs these tokens with RS256.
            // Without this, JWK::parseKeySet() throws "JWK must contain an alg parameter".
            foreach ($jwk['keys'] as &$key) {
                if (!isset($key['alg'])) {
                    $key['alg'] = 'RS256';
                }
            }
            unset($key); // break reference

            Log::info('CyberSourceJwtVerifier: public key fetched and cached', [
                'kid'       => $kid,
                'cache_ttl' => self::CACHE_TTL_SECONDS,
                'key_type'  => $jwk['keys'][0]['kty'] ?? 'unknown',
                'alg'       => $jwk['keys'][0]['alg'] ?? 'injected:RS256',
            ]);

            return $jwk;
        });
    }
}
