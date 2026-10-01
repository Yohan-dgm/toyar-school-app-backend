<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class ChatPollVote extends Model
{
    use HasFactory;

    protected $table = 'chat_poll_votes';

    public $timestamps = false;

    protected $fillable = [
        'chat_poll_option_id',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(ChatPollOption::class, 'chat_poll_option_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
