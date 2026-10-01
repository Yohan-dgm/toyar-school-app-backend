<?php

namespace App\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Models\User;

class AuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bearer = $request->bearerToken();
        if (! $bearer) {
            return response()->json(
                [
                    'status' => 'authentication-required',
                    'message' => '',
                    'data' => null,
                    'metadata' => null,
                ],
                401
            );
        }
        // Handle bearer token format - check if it contains '|' separator
        $tokenParts = explode('|', $bearer, 2);
        if (count($tokenParts) !== 2) {
            return response()->json(
                [
                    'status' => 'authentication-required',
                    'message' => 'Invalid token format',
                    'data' => null,
                    'metadata' => null,
                ],
                401
            );
        }
        [$id, $token] = $tokenParts;

        $sessionCookie = $request->cookie('t_session');
        if (! $sessionCookie) {
            return response()->json(
                [
                    'status' => 'authentication-required',
                    'message' => 'Session cookie required',
                    'data' => null,
                    'metadata' => null,
                ],
                401
            );
        }

        try {
            $decryptedSession = Crypt::decrypt($sessionCookie);
            Log::info('from Sanctum middleware: '.$decryptedSession);

            app('db')->extend('pgsqlt', function ($config, $name) use ($decryptedSession) {
                $config['database'] = $decryptedSession;

                return app('db.factory')->make($config, $name);
            });
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'authentication-required',
                    'message' => 'Invalid session cookie',
                    'data' => null,
                    'metadata' => null,
                ],
                401
            );
        }

        // Safely purge the dynamic database connection
        try {
            DB::purge('pgsqlt');
        } catch (\Exception $e) {
            Log::warning('Failed to purge pgsqlt connection', [
                'error' => $e->getMessage(),
                'connection' => 'pgsqlt'
            ]);
            // Continue execution - purge failure shouldn't break authentication
        }
        // Cookie::queue(Cookie::forget('t_session'));

        $instance = DB::table('personal_access_tokens')->find($id);
        if (is_null($instance)) {
            return response()->json(
                [
                    'status' => 'authentication-required',
                    'message' => '',
                    'data' => null,
                    'metadata' => null,
                ],
                401
            );
        } else {
            if (hash('sha256', $token) === $instance->token) {
                if ($user = User::find($instance->tokenable_id)) {
                    // Temporarily switch back to default connection for session operations
                    $originalDefault = config('database.default');
                    $originalSessionConnection = config('session.connection');
                    
                    config(['database.default' => 'pgsql']);
                    config(['session.connection' => 'pgsql']);
                    
                    Auth::login($user);
                    
                    // Switch back to tenant database
                    config(['database.default' => $originalDefault]);
                    config(['session.connection' => $originalSessionConnection]);

                    return $next($request);
                }
            } else {
                return response()->json(
                    [
                        'status' => 'authentication-required',
                        'message' => '',
                        'data' => null,
                        'metadata' => null,
                    ],
                    401
                );
            }
        }
    }
}
