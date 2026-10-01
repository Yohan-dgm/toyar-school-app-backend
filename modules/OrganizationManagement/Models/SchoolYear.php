<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model
{
    use HasFactory;

    protected $table = 'school_year';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'school_location_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function school_date_list(): HasMany
    {
        return $this->hasMany(SchoolDate::class, 'school_year_id', 'id');
    }

    public function school_location(): BelongsTo
    {
        return $this->belongsTo(SchoolLocation::class, 'school_location_id', 'id');
    }
    // protected static function newFactory(): SchoolLocationFactory
    // {
    //     return new SchoolLocationFactory();
    // }
}
