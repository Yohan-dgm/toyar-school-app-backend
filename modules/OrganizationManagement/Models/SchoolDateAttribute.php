<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolDateAttribute extends Model
{
    use HasFactory;

    protected $table = 'school_date_attribute';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function school_date_list(): BelongsToMany
    {
        return $this->belongsToMany(SchoolDate::class, 'school_date_school_date_attribute_pivot', 'school_date_attribute_id', 'school_date_id');
    }

    // protected static function newFactory(): SchoolLocationFactory
    // {
    //     return new SchoolLocationFactory();
    // }
}
