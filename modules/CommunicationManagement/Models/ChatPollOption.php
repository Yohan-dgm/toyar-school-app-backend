<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatPollOption extends Model
{
    use HasFactory;

    protected $table = 'chat_poll_options';

    protected $fillable = [
        'chat_message_poll_id',
        'option_text',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(ChatMessagePoll::class, 'chat_message_poll_id', 'id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ChatPollVote::class, 'chat_poll_option_id');
    }
}
