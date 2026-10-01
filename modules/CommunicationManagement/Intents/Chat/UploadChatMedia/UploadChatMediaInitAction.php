<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadChatMedia;

use Exception;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Services\ChunkedUploadService;

class UploadChatMediaInitAction
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
            'filename' => 'required|string|max:255',
            'total_size' => 'required|integer|max:52428800', // 50MB
            'mime_type' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $userId = $actionData['user_id'];
        $filename = $payloadArray['filename'];
        $totalSize = $payloadArray['total_size'];
        $mimeType = $payloadArray['mime_type'] ?? null;

        $fileUpload = $this->chunkedUploadService->initialize($userId, $filename, $totalSize, $mimeType);

        return [
            'upload_id' => $fileUpload->id,
            'total_size' => $fileUpload->total_size,
            'uploaded_size' => $fileUpload->uploaded_size,
            'status' => $fileUpload->status,
        ];
    }
}
