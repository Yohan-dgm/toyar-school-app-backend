<?php

namespace Modules\LogManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamLog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_log';

    protected $fillable = [
        'description',
        'user_name',
        'type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

}
