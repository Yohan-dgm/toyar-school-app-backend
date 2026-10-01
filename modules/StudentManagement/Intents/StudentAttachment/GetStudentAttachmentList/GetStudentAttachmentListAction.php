<?php

namespace Modules\StudentManagement\Intents\StudentAttachment\GetStudentAttachmentList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\StudentAttachment;

class GetStudentAttachmentListAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getStudentAttachmentListUserDTO = GetStudentAttachmentListUserDTO::validate($payloadArray);

        $studentId = $getStudentAttachmentListUserDTO['student_id'];

        $attachments = StudentAttachment::where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'student_id' => $attachment->student_id,
                    'file_name' => $attachment->file_name,
                    'original_file_name' => $attachment->original_file_name,
                    'mime_type' => $attachment->mime_type,
                    'created_info' => [
                        'created_by' => $attachment->created_by,
                        'updated_by' => $attachment->updated_by,
                        'created_at' => $attachment->created_at?->toISOString(),
                        'updated_at' => $attachment->updated_at?->toISOString(),
                    ],
                ];
            })
            ->toArray();

        return [
            'attachments' => $attachments,
        ];
    }
}
