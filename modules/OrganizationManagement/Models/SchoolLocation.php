<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ProgramManagement\Models\Program;

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

    public function program_list(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_school_location_pivot', 'school_location_id', 'program_id');
    }

    public function school_year_list(): HasMany
    {
        return $this->hasMany(SchoolYear::class, 'school_location_id', 'id');
    }

    // protected static function newFactory(): SchoolLocationFactory
    // {
    //     return new SchoolLocationFactory();
    // }
}
