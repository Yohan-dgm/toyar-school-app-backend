<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class Educator extends Model
{
    use HasFactory;

    protected $table = 'educator';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function educator_attendance_list(): HasMany
    {
        return $this->hasMany(EducatorAttendance::class, 'educator_id', 'id');
    }

    // protected static function newFactory(): EducatorFactory
    // {
    //     return new EducatorFactory();
    // }
}
