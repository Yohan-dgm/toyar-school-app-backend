<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbQuestionAnswer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_question_answer';

    protected $fillable = [
        'edu_fb_id',
        'selected_predefined_answer_id',
        'edu_fb_predefined_question_id',
        'edu_fb_predefined_answer_id',
        'answer_mark',
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
    public function feedback(): BelongsTo
    {
        return $this->belongsTo(EduFb::class, 'edu_fb_id', 'id');
    }

    public function predefined_question(): BelongsTo
    {
        return $this->belongsTo(EduFbPredefinedQuestion::class, 'edu_fb_predefined_question_id', 'id');
    }

    public function predefined_answer(): BelongsTo
    {
        return $this->belongsTo(EduFbPredefinedAnswer::class, 'edu_fb_predefined_answer_id', 'id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
