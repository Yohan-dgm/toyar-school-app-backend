<?php

namespace App\Middleware;

use Closure;
use App\Traits\UserTrackingTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserTrackingMiddleware
{
    use UserTrackingTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\App\Library\Response\HttpResponse|\App\Library\Response\RedirectResponse)  $next
     * @return \App\Library\Response\HttpResponse|\App\Library\Response\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof BinaryFileResponse) {
        } else {
            if (!is_null($request->user())) {
                $content = json_decode($response->content(), true);
                if (!is_null($content) && array_key_exists('metadata', $content)) {
                    $content['metadata']['is_system_update_pending'] = $request->user()->is_system_update_pending;
                }
                //Check if the response is JSON
                if (json_last_error() == JSON_ERROR_NONE) {
                    $response->setContent(json_encode($content));
                }
            }
        }

        return $response;
    }
}
