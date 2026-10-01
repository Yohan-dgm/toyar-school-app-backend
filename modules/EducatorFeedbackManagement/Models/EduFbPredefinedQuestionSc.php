<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbPredefinedQuestionSc extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_predefined_question_sc';

    protected $fillable = [
        'question',
        'edu_fb_category_sc_id',
        'edu_fb_answer_type_id',
        'is_active',
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
    public function category(): BelongsTo
    {
        return $this->belongsTo(EduFbCategorySc::class, 'edu_fb_category_sc_id', 'id');
    }

    public function predefined_answers(): HasMany
    {
        return $this->hasMany(EduFbPredefinedAnswerSc::class, 'edu_fb_predefined_question_sc_id', 'id');
    }

    public function question_answers(): HasMany
    {
        return $this->hasMany(EduFbQuestionAnswer::class, 'edu_fb_predefined_question_id', 'id');
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