<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbPredefinedAnswerPr extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_predefined_answer_pr';

    protected $fillable = [
        'predefined_answer',
        'edu_fb_predefined_question_pr_id',
        'predefined_answer_weight',
        'marks',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'predefined_answer_weight' => 'integer',
        'marks' => 'integer',
        'is_active' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relations
    public function predefined_question(): BelongsTo
    {
        return $this->belongsTo(EduFbPredefinedQuestionPr::class, 'edu_fb_predefined_question_pr_id', 'id');
    }

    public function question_answers(): HasMany
    {
        return $this->hasMany(EduFbQuestionAnswer::class, 'edu_fb_predefined_answer_id', 'id');
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