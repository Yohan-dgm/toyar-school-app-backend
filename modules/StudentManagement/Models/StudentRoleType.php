<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class StudentRoleType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_role_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // Relations
    public function student_roles(): HasMany
    {
        return $this->hasMany(StudentRole::class, 'role_type_id', 'id');
    }

    public function active_student_roles(): HasMany
    {
        return $this->student_roles()->where('is_active', true);
    }
}
