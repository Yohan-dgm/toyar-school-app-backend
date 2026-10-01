<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessageReaction extends Model
{
    protected $fillable = [
        'chat_message_id',
        'user_id',
        'emoji',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'chat_message_id');
    }

    public function user(): BelongsTo
    {
        // Assuming there's a User model in the root namespace or another module
        return $this->belongsTo(\App\Models\User::class);
    }
}
