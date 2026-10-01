<?php

namespace Modules\EventManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Modules\EmployeeManagement\Models\Employee;
use Modules\OrganizationManagement\Models\SchoolDate;

class Event extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'event';

    protected $fillable = [
        'name',
        'school_date_id',
        'duration_type',
        'start_time',
        'end_time',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function employee_list(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'event_event_manager_pivot', 'event_id', 'employee_id');
    }

    public function school_date(): BelongsTo
    {
        return $this->belongsTo(SchoolDate::class, 'school_date_id', 'id');
    }
    // factory
    // protected static function newFactory(): EventFactory
    // {
    //     return new EventFactory();
    // }
}
