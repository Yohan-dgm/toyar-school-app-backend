<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\EmployeeManagement\Models\Employee;

class ClassSection extends Model
{
    protected $table = 'class_section';

    protected $fillable = [
        'name',
        'section_head_id', //employee_id
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function section_head(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'section_head_id', 'id');
    }
}
