<?php

namespace Modules\CommunicationManagement\Intents\Chat\UploadVoiceNote;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\CommunicationManagement\Models\ChatGroup;

// Dedicated, additive upload endpoint for voice notes — deliberately does
// NOT route through MediaUploadService::uploadMediaStandalone(), which has
// a hard-coded image/video/pdf-only MIME + extension whitelist that would
// reject every audio file. Voice notes are small (a few MB even for
// several minutes of AAC audio), so unlike video they don't need the
// chunked-upload machinery either — a single multipart request is enough.
//
// Validates by file EXTENSION rather than server-detected MIME type:
// PHP's fileinfo/libmagic detection for .m4a is inconsistent across
// versions (audio/mp4, audio/x-m4a, audio/m4a all show up in practice for
// the same file), so trusting the extension (which the app controls) is
// more reliable than trying to allow-list every possible detected string.
class UploadVoiceNoteAction
{
    use AsAction;

    private const MAX_SIZE_KB = 20480; // 20MB
    private const ALLOWED_EXTENSIONS = ['m4a', 'mp3', 'aac', 'wav', 'caf'];

    public function handle(array $payloadArray, array $actionData): array
    {
        $userId = $actionData['user_id'];

        $validator = Validator::make($payloadArray, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'audio' => 'required|file|max:'.self::MAX_SIZE_KB,
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $chatGroupId = $payloadArray['chat_group_id'];
        $group = ChatGroup::findOrFail($chatGroupId);

        if (!$group->isMember($userId)) {
            throw ValidationException::withMessages([
                'chat_group_id' => ['You are not a member of this chat group.'],
            ]);
        }

        // Per-group enable/disable toggle intentionally not enforced yet —
        // disabled for now (not wired up end-to-end), so voice notes always
        // work regardless of the chat_groups.is_voicenote flag.

        /** @var UploadedFile $file */
        $file = $payloadArray['audio'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new Exception('Unsupported voice note format: '.$extension);
        }

        $filename = sprintf(
            'voice-%d-%d-%s.%s',
            $userId,
            time(),
            substr(md5(random_bytes(8)), 0, 8),
            $extension
        );

        $storageDir = 'nexis-college/yakkala/chat/media/audio';
        Storage::disk('public')->putFileAs($storageDir, $file, $filename);
        $fullPath = $storageDir.'/'.$filename;

        return [
            'url' => '/storage/'.$fullPath,
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType() ?: 'audio/'.$extension,
        ];
    }
}
