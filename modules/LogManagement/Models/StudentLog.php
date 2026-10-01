<?php

namespace Modules\LogManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StudentLog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_log';

    protected $fillable = [
        'description',
        'user_name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

}
