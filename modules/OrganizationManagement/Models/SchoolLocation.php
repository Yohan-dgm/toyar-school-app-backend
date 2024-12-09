<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolLocation extends Model
{
    use HasFactory;

    protected $table = 'school_location';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // protected static function newFactory(): SchoolLocationFactory
    // {
    //     return new SchoolLocationFactory();
    // }
}
