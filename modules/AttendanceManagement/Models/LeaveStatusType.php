<?php

namespace Modules\AttendanceManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveStatusType extends Model
{
    protected $table = 'leave_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public function leave_list(): HasMany
    {
        return $this->hasMany(Leave::class, 'leave_status_type_id', 'id');
    }
}
