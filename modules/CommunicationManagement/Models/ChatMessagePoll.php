<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\UserManagement\Models\User;

class ChatMessagePoll extends Model
{
    use HasFactory;

    protected $table = 'chat_message_polls';

    protected $fillable = [
        'chat_message_id',
        'allows_multiple_answers',
        'is_closed',
        'closed_at',
        'closed_by',
    ];

    protected $casts = [
        'allows_multiple_answers' => 'boolean',
        'is_closed' => 'boolean',
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'chat_message_id', 'id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(ChatPollOption::class, 'chat_message_poll_id')->orderBy('position');
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by', 'id');
    }

    /**
     * Aggregate-only summary (vote counts, never voter identities) — safe to
     * embed in any response or realtime broadcast that reaches every member.
     * $requestingUserId is used only to report that one user's own vote
     * back to them, which is safe since it's their own data.
     */
    public function toSummaryArray(?int $requestingUserId = null): array
    {
        $this->loadMissing('options.votes');

        $totalVotes = 0;
        $myVotedOptionIds = [];

        $options = $this->options->map(function (ChatPollOption $option) use ($requestingUserId, &$totalVotes, &$myVotedOptionIds) {
            $count = $option->votes->count();
            $totalVotes += $count;

            if ($requestingUserId && $option->votes->contains('user_id', $requestingUserId)) {
                $myVotedOptionIds[] = $option->id;
            }

            return [
                'id' => $option->id,
                'text' => $option->option_text,
                'vote_count' => $count,
            ];
        })->values()->toArray();

        return [
            'id' => $this->id,
            'allows_multiple_answers' => $this->allows_multiple_answers,
            'is_closed' => $this->is_closed,
            'closed_at' => optional($this->closed_at)->toISOString(),
            'total_votes' => $totalVotes,
            'options' => $options,
            'my_voted_option_ids' => $myVotedOptionIds,
        ];
    }
}
