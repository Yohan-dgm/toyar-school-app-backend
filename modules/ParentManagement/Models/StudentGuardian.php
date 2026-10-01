<?php

namespace Modules\ParentManagement\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    protected $table = 'student_guardian';

    protected $fillable = [
        'full_name',
        'id_type',
        'nic_number',
        'passport_number',
        'phone',
        'whatsapp',
        'email',
        'occupation',
        'place_of_work',
        'monthly_income',
        'guardian_type', // 1=father, 2=mother, 3=guardian
        'user_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;
}
