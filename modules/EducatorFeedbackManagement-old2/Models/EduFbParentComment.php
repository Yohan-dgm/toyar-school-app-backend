<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;

class EduFbParentComment extends Model
{
    use HasFactory;

    protected $table = 'edu_fb_parent_comments';

    protected $fillable = [
        'edu_fb_id',
        'comment',
        'created_by',
        'updated_by',
        'is_active',
        'edited_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'edited_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relations

    public function educatorFeedback(): BelongsTo
    {
        return $this->belongsTo(EduFb::class, 'edu_fb_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
