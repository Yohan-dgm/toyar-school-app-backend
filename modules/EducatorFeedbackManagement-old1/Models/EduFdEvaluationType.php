<?php

namespace Modules\EducatorFeedbackManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class EduFdEvaluationType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'edu_fd_evaluation_type';

    protected $fillable = [
        'name',
        'status_code',
        'description',
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
    public function evaluations(): HasMany
    {
        return $this->hasMany(EduFdEvaluation::class, 'edu_fd_evaluation_type_id', 'id');
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
