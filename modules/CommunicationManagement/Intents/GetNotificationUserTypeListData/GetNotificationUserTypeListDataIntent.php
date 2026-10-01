<?php

namespace Modules\CommunicationManagement\Intents\GetNotificationUserTypeListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNotificationUserTypeListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        // Validation
        $getNotificationUserTypeListDataUserDTO =
            GetNotificationUserTypeListDataUserDTO::validate($request->all());

        // Action
        $actionData = [];
        $userList = GetNotificationUserTypeListDataAction::run(
            $getNotificationUserTypeListDataUserDTO,
            $actionData
        );

        return [
            'data'  => $userList->all(),
            'total' => $userList->count(),
        ];
    }

    public function asController(Request $request): JsonResponse
    {
        $result = $this->handle($request);

        $resDTO =
            GetNotificationUserTypeListDataResDTO::validate($result);

        return response()->json(
            [
                'status'   => 'successful',
                'message'  => '',
                'data'     => $resDTO,
                'metadata' => null,
            ],
            200
        );
    }
}
