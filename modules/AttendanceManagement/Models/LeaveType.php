<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EmployeeManagement\Models\EmployeeLeave;

class LeaveType extends Model
{
    protected $table = 'leave_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public function leave_list(): HasMany
    {
        return $this->hasMany(Leave::class, 'leave_type_id', 'id');
    }
}
