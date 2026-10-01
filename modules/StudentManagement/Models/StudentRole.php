<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\Sport;

class StudentRole extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_role';

    protected $fillable = [
        'student_id',
        'role_type_id',
        'academic_year',
        'assigned_date',
        'relieved_date',
        'remarks',
        'is_active',

        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function role_type(): BelongsTo
    {
        return $this->belongsTo(StudentRoleType::class, 'role_type_id', 'id');
    }

    // factory
    // protected static function newFactory(): BankAccountFactory
    // {
    //     return new BankAccountFactory();
    // }
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class, 'sport_id', 'id');
    }

    public function student_list(): HasMany
    {
        return $this->hasMany(Student::class, 'student_id', 'id');
    }

    public function sport_list(): HasMany
    {
        return $this->hasMany(Sport::class, 'sport_id', 'id');
    }
}
