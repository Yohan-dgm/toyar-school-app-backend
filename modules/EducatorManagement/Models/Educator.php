<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\AttendanceManagement\Models\EducatorAttendance;
use Modules\EmployeeManagement\Models\Employee;

class Educator extends Model
{
    use HasFactory;

    protected $table = 'educator';

    protected $fillable = [
        'employee_id',
        'educator_grade_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function educator_attendance_list(): HasMany
    {
        return $this->hasMany(EducatorAttendance::class, 'educator_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function educator_grade(): BelongsTo
    {
        return $this->belongsTo(EducatorGrade::class, 'educator_grade_id', 'id');
    }

    // protected static function newFactory(): EducatorFactory
    // {
    //     return new EducatorFactory();
    // }
}
