<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Modules\AccountManagement\Services\CyberSourceJwtVerifier;

// ── Helpers ────────────────────────────────────────────────────────────────────

/**
 * Generate a fresh RSA-2048 key pair for each test.
 * Returns ['private' => string (PEM), 'public' => string (PEM)].
 */
function generateRsaKeyPair(): array
{
    $resource = openssl_pkey_new([
        'digest_alg'       => 'sha256',
        'private_key_bits' => 2048,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]);

    openssl_pkey_export($resource, $privatePem);
    $details = openssl_pkey_get_details($resource);

    return [
        'private'  => $privatePem,
        'public'   => $details['key'],
        'resource' => $resource,
    ];
}

/**
 * Build a minimal RS256 JWT signed with the given RSA private key PEM.
 *
 * @param  array  $payload   JWT payload fields
 * @param  string $kid       Key ID to embed in the header
 * @param  string $privatePem RSA private key in PEM format
 * @param  string $alg       Algorithm to put in the header (default RS256)
 */
function buildJwt(array $payload, string $kid, string $privatePem, string $alg = 'RS256'): string
{
    $header  = base64url_encode(json_encode(['kid' => $kid, 'alg' => $alg]));
    $body    = base64url_encode(json_encode($payload));
    $signing = "{$header}.{$body}";

    openssl_sign($signing, $signature, $privatePem, OPENSSL_ALGO_SHA256);

    return "{$signing}." . base64url_encode($signature);
}

function base64url_encode(string $data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Convert an RSA public key PEM to JWK format (n, e components).
 * This replicates what CyberSource's /flex/v2/public-keys/{kid} returns.
 */
function rsaPublicKeyToJwk(string $publicPem, string $kid): array
{
    $key     = openssl_pkey_get_public($publicPem);
    $details = openssl_pkey_get_details($key);
    $rsa     = $details['rsa'];

    return [
        'kty' => 'RSA',
        'kid' => $kid,
        // Note: NO "alg" field — this matches what CyberSource actually returns
        'n'   => base64url_encode($rsa['n']),
        'e'   => base64url_encode($rsa['e']),
        'use' => 'sig',
    ];
}

// ── Shared setup ───────────────────────────────────────────────────────────────

beforeEach(function () {
    // Use array cache driver — no Redis needed in tests
    config(['cache.default' => 'array']);
    config(['services.cybersource.env' => 'test']);
    Cache::flush();
});

// ── Tests ──────────────────────────────────────────────────────────────────────

test('verifies a valid RS256 signed CyberSource UC result JWT', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-valid-001';

    $payload = [
        'status'  => 'AUTHORIZED',
        'id'      => '7842691888186293204010',
        'message' => 'Payment authorized',
        'iat'     => time() - 10,
        'exp'     => time() + 300,
    ];

    $jwt = buildJwt($payload, $kid, $keys['private']);
    $jwk = rsaPublicKeyToJwk($keys['public'], $kid);

    // Mock CyberSource public key endpoint — returns JWK without "alg" (real behaviour)
    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();
    $result   = $verifier->verify($jwt);

    expect($result['status'])->toBe('AUTHORIZED');
    expect($result['id'])->toBe('7842691888186293204010');
});

test('rejects a JWT whose signature has been tampered with', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-tampered-002';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => '7842000000000000000000',
        'iat'    => time() - 10,
        'exp'    => time() + 300,
    ];

    $jwt = buildJwt($payload, $kid, $keys['private']);

    // Tamper: replace the payload section with a different (higher) amount
    $parts          = explode('.', $jwt);
    $forgedPayload  = array_merge($payload, ['id' => 'FORGED-TX-ID-99999']);
    $parts[1]       = base64url_encode(json_encode($forgedPayload));
    $tamperedJwt    = implode('.', $parts);

    $jwk = rsaPublicKeyToJwk($keys['public'], $kid);
    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify($tamperedJwt))
        ->toThrow(\Exception::class, 'CyberSource JWT verification failed');
});

test('rejects a JWT signed with a different private key (forged token)', function () {
    $realKeys  = generateRsaKeyPair();
    $attackerKeys = generateRsaKeyPair();
    $kid = 'test-kid-forged-003';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => 'FORGED-FREE-PAYMENT',
        'iat'    => time() - 10,
        'exp'    => time() + 300,
    ];

    // Attacker signs with their own private key
    $forgedJwt = buildJwt($payload, $kid, $attackerKeys['private']);

    // Backend has CyberSource's REAL public key
    $jwk = rsaPublicKeyToJwk($realKeys['public'], $kid);
    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify($forgedJwt))
        ->toThrow(\Exception::class, 'CyberSource JWT verification failed');
});

test('rejects an expired JWT', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-expired-004';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => '7842000000000000000000',
        'iat'    => time() - 3600,
        'exp'    => time() - 120, // expired 2 minutes ago (beyond leeway of 60s)
    ];

    $jwt = buildJwt($payload, $kid, $keys['private']);
    $jwk = rsaPublicKeyToJwk($keys['public'], $kid);

    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify($jwt))
        ->toThrow(\Exception::class, 'CyberSource JWT verification failed: token is expired');
});

test('rejects a JWT with a non-RS256 algorithm (algorithm confusion guard)', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-alg-005';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => '7842000000000000000000',
        'iat'    => time() - 10,
        'exp'    => time() + 300,
    ];

    // Build a JWT with alg:none in the header — do not sign
    $header = base64url_encode(json_encode(['kid' => $kid, 'alg' => 'none']));
    $body   = base64url_encode(json_encode($payload));
    $noneJwt = "{$header}.{$body}.";

    Http::fake(); // No HTTP call should be made — should fail at algorithm guard

    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify($noneJwt))
        ->toThrow(\Exception::class, "algorithm 'none' is not allowed");
});

test('rejects a JWT with a future iat (backdated/forged token)', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-iat-006';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => '7842000000000000000000',
        'iat'    => time() + 600, // issued 10 minutes in the future
        'exp'    => time() + 900,
    ];

    $jwt = buildJwt($payload, $kid, $keys['private']);
    $jwk = rsaPublicKeyToJwk($keys['public'], $kid);

    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify($jwt))
        ->toThrow(\Exception::class, 'CyberSource JWT verification failed');
});

test('caches the public key and does not make a second HTTP call for same kid', function () {
    $keys = generateRsaKeyPair();
    $kid  = 'test-kid-cache-007';

    $payload = [
        'status' => 'AUTHORIZED',
        'id'     => '7842000000000000000001',
        'iat'    => time() - 5,
        'exp'    => time() + 300,
    ];

    $jwt = buildJwt($payload, $kid, $keys['private']);
    $jwk = rsaPublicKeyToJwk($keys['public'], $kid);

    Http::fake([
        "https://apitest.cybersource.com/flex/v2/public-keys/{$kid}" => Http::response($jwk, 200),
    ]);

    $verifier = new CyberSourceJwtVerifier();

    // First call → HTTP fetch
    $verifier->verify($jwt);

    // Second call → should use cached key, no second HTTP call
    $verifier->verify($jwt);

    // Assert only ONE HTTP request was made
    Http::assertSentCount(1);
});

test('rejects a malformed JWT with fewer than 3 parts', function () {
    $verifier = new CyberSourceJwtVerifier();

    expect(fn () => $verifier->verify('not.a.valid.jwt.with.too.many.parts'))
        ->toThrow(\Exception::class, 'malformed JWT');

    expect(fn () => $verifier->verify('onlytwoparts.here'))
        ->toThrow(\Exception::class, 'malformed JWT');
});
