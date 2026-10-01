<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\EventManagement\Models\Event;

class SchoolDate extends Model
{
    use HasFactory;

    protected $table = 'school_date';

    protected $fillable = [
        'school_year_id',
        'date',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function school_year(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id', 'id');
    }

    public function event_list(): HasMany
    {
        return $this->hasMany(Event::class, 'school_date_id', 'id');
    }

    public function school_date_attribute_list(): BelongsToMany
    {
        return $this->belongsToMany(SchoolDateAttribute::class, 'school_date_school_date_attribute_pivot', 'school_date_id', 'school_date_attribute_id');
    }

    // protected static function newFactory(): SchoolLocationFactory
    // {
    //     return new SchoolLocationFactory();
    // }
}
