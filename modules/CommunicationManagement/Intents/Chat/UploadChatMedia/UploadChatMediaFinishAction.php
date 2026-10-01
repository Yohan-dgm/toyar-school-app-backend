<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadChatMedia;

use Exception;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\FileUpload;
use Modules\CommunicationManagement\Services\ChunkedUploadService;

class UploadChatMediaFinishAction
{
    use AsAction;

    private ChunkedUploadService $chunkedUploadService;

    public function __construct(ChunkedUploadService $chunkedUploadService)
    {
        $this->chunkedUploadService = $chunkedUploadService;
    }

    public function handle(array $payloadArray, array $actionData): array
    {
        $validator = Validator::make($payloadArray, [
            'upload_id' => 'required|integer|exists:file_uploads,id',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $userId = $actionData['user_id'];
        $uploadId = $payloadArray['upload_id'];

        $fileUpload = FileUpload::where('id', $uploadId)->where('user_id', $userId)->firstOrFail();

        $result = $this->chunkedUploadService->finalize($fileUpload);

        return [
            'upload_id' => $fileUpload->id,
            'status' => 'completed',
            'media' => $result,
        ];
    }
}
