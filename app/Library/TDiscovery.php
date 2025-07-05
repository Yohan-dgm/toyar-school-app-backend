<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class TDiscovery extends TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant
    {
        if ($request->path() == "api/user-management/user/sign-in") {
            if (is_null($request->post('pin')) || is_null(app(IsTenant::class)::where('database', $request->post('pin'))->first())) {
                return app(IsTenant::class)::whereDomain('0.0.0.0')->first();
            } else {
                return app(IsTenant::class)::where('database', $request->post('pin'))->first();
            }
        } else {
            if (!is_null($request->cookie('t_session'))) {
                if (is_null(app(IsTenant::class)::where('database', Crypt::decrypt($request->cookie('t_session')))->first())) {
                    return app(IsTenant::class)::whereDomain('0.0.0.0')->first();
                } else {
                    return app(IsTenant::class)::where('database', Crypt::decrypt($request->cookie('t_session')))->first();
                }
            } else {
                return app(IsTenant::class)::whereDomain('0.0.0.0')->first();
            }
        }
    }
}
