<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbCategorySc extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_category_sc';

    protected $fillable = [
        'name',
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
    public function feedback_list(): HasMany
    {
        return $this->hasMany(EduFb::class, 'edu_fb_category_id', 'id');
    }

    public function predefined_questions(): HasMany
    {
        return $this->hasMany(EduFbPredefinedQuestionSc::class, 'edu_fb_category_sc_id', 'id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(EduFbSubcategory::class, 'edu_fb_category_id', 'id');
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