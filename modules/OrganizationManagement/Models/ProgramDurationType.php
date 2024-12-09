<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ProgramManagement\Models\Program;

class ProgramDurationType extends Model
{
    use HasFactory;

    protected $table = 'program_duration_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function program_list(): HasMany
    {
        return $this->hasMany(Program::class, 'program_duration_type_id', 'id');
    }

    // protected static function newFactory(): ProgramDurationTypeFactory
    // {
    //     return new ProgramDurationTypeFactory();
    // }
}
