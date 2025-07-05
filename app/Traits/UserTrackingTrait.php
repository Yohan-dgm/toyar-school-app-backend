<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use App\Models\UserTracking as ModelUserTracking;

trait UserTrackingTrait
{

    public function Track($Transaction = true, $Params = [])
    {
        // DB::beginTransaction();
        // try {
        //     $UserTracking = new ModelUserTracking;
        //     $UserTracking->transaction = $Transaction;
        //     $UserTracking->event = Route::currentRouteName();
        //     $UserTracking->class = Route::currentRouteAction();
        //     $UserTracking->request_params = json_encode(request()->all());
        //     $UserTracking->request_method = Route::current()->methods()[0];
        //     $UserTracking->request_ip = request()->ip();
        //     $UserTracking->request_userAgent = request()->userAgent();
        //     if (!empty($Params)): $UserTracking->params = json_encode($Params);
        //     endif;
        //     $UserTracking->User()->associate(Auth::user());
        //     $UserTracking->save();

        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();

        //     Log::error("Insert User Tracking Data Error", [
        //         'UserTracking' => $UserTracking,
        //         'Exception' => $e->getMessage()
        //     ]);
        // }
    }
}
