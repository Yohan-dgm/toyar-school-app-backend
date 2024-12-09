<?php

namespace Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ProgramManagement\Models\Program;

class CurriculumType extends Model
{
    use HasFactory;

    protected $table = 'curriculum_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function program_list(): HasMany
    {
        return $this->hasMany(Program::class, 'curriculum_type_id', 'id');
    }

    // protected static function newFactory(): CurriculumTypeFactory
    // {
    //     return new CurriculumTypeFactory();
    // }
}
