<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFbSubcategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fb_subcategory';

    protected $fillable = [
        'edu_fb_id',
        'edu_fb_category_id',
        'subcategory_name',
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
        return $this->belongsTo(EduFbCategory::class, 'edu_fb_category_id', 'id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
