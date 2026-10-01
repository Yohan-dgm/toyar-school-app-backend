<?php

namespace Modules\EducatorManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\UserManagement\Models\User;

class EducatorRole extends Model
{
    use HasFactory;

    protected $table = 'educator_role';

    protected $fillable = [
        'user_id',
        'educator_id',
        'role_type_id',
        'created_at',
        'updated_at',
        'academic_year',
        'assigned_date',
        'relieved_date',
        'remarks',
        'is_active',
        'created_by',
        'updated_by',
        'grade_level_id',
    ];

    public $timestamps = true;

    // public function educator_role_list(): HasMany
    // {
    //     return $this->hasMany(Educator::class, 'educator_role_id', 'id');
    // }

    // protected static function newFactory(): EducatorRoleFactory
    // {
    //     return new EducatorRoleFactory();
    // }

    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
