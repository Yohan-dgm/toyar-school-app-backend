<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\UserManagement\Models\User;

class ChatGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chat_groups';

    protected $fillable = [
        'name',
        'type',
        'avatar_url',
        'school_id',
        'is_disabled',
        'only_admins_can_message',
        'is_voicenote',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'only_admins_can_message' => 'boolean',
        'is_voicenote' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function members(): HasMany
    {
        return $this->hasMany(ChatGroupMember::class, 'chat_group_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_group_id', 'id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_group_id', 'id')->latest();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where('is_active', true);
        });
    }

    // Helper methods
    public function isMember($userId)
    {
        return $this->members()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }

    public function isAdmin($userId)
    {
        return $this->members()
            ->where('user_id', $userId)
            ->where('role', 'admin')
            ->where('is_active', true)
            ->exists();
    }
}
