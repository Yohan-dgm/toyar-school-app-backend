<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class ChatGroupMember extends Model
{
    use HasFactory;

    protected $table = 'chat_group_members';

    protected $fillable = [
        'chat_group_id',
        'user_id',
        'role',
        'last_read_at',
        'is_active',
        'joined_at',
        'is_pinned',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
        'is_active' => 'boolean',
        'joined_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    public $timestamps = true;

    // Relationships
    public function group(): BelongsTo
    {
        return $this->belongsTo(ChatGroup::class, 'chat_group_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Helper methods
    public function updateLastRead()
    {
        $this->update([
            'last_read_at' => now(),
        ]);
    }
}
