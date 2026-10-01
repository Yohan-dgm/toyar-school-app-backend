<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbBackup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_backup';

    protected $fillable = [
        'student_id',
        'comment',
        'grade_level_id',
        'grade_level_class_id',
        'edu_fb_category_id',
        'rating',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relations

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
