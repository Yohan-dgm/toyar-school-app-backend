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
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bearer = $request->bearerToken();
        if (!$bearer) {
            return response()->json(
                [
                    "status" => "authentication-required",
                    "message" => "",
                    "data" => null,
                    "metadata" => null,
                ],
                401
            );
        }
        [$id, $token] = explode('|', $bearer, 2);

        Log::info("from Sanctum middleware: " . Crypt::decrypt($request->cookie('t_session')));

        app('db')->extend('pgsqlt', function ($config, $name) use ($request) {
            $config['database'] = Crypt::decrypt($request->cookie('t_session'));
            return app('db.factory')->make($config, $name);
        });
        DB::purge('pgsqlt');
        // Cookie::queue(Cookie::forget('t_session'));

        $instance = DB::table('personal_access_tokens')->find($id);
        if (is_null($instance)) {
            return response()->json(
                [
                    "status" => "authentication-required",
                    "message" => "",
                    "data" => null,
                    "metadata" => null,
                ],
                401
            );
        } else {
            if (hash('sha256', $token) === $instance->token) {
                if ($user = User::find($instance->tokenable_id)) {
                    Auth::login($user);
                    return $next($request);
                }
            } else {
                return response()->json(
                    [
                        "status" => "authentication-required",
                        "message" => "",
                        "data" => null,
                        "metadata" => null,
                    ],
                    401
                );
            }
        }
    }
}
