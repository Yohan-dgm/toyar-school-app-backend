<?php

namespace Modules\AcademicStaffManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\UserManagement\Models\User;
use Modules\ProgramManagement\Models\GradeLevelClass;

class ClassTeacher extends Model
{
    protected $table = 'class_teacher';

    protected $fillable = [
        'user_id',
        'grade_level_class_id',
        'academic_year',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public $timestamps = true;

    /**
     * Get the user (teacher) assigned to this class
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the grade level class for this assignment
     */
    public function grade_level_class(): BelongsTo
    {
        return $this->belongsTo(GradeLevelClass::class, 'grade_level_class_id', 'id');
    }

    /**
     * Get the user who created this record
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the user who last updated this record
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Scope to get only active assignments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by academic year
     */
    public function scopeAcademicYear($query, $academicYear)
    {
        return $query->where('academic_year', $academicYear);
    }

    /**
     * Scope to get current assignments (within date range)
     */
    public function scopeCurrent($query)
    {
        $today = now()->toDateString();
        return $query->where('start_date', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            });
    }
}
