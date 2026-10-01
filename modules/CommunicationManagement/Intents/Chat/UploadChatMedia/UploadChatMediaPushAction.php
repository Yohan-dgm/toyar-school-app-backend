<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadChatMedia;

use Exception;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\FileUpload;
use Modules\CommunicationManagement\Services\ChunkedUploadService;

class UploadChatMediaPushAction
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
            'chunk' => 'required|file',
            'offset' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $userId = $actionData['user_id'];
        $uploadId = $payloadArray['upload_id'];
        $chunk = $payloadArray['chunk'];
        $offset = (int) $payloadArray['offset'];

        $fileUpload = FileUpload::where('id', $uploadId)->where('user_id', $userId)->firstOrFail();

        $fileUpload = $this->chunkedUploadService->appendChunk($fileUpload, $chunk, $offset);

        return [
            'upload_id' => $fileUpload->id,
            'uploaded_size' => $fileUpload->uploaded_size,
            'total_size' => $fileUpload->total_size,
            'status' => $fileUpload->status,
        ];
    }
}
