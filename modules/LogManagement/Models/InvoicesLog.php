<?php

namespace Modules\LogManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class InvoicesLog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'invoices_log';

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
