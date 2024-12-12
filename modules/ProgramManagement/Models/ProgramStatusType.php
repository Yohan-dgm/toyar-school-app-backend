<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStatusType extends Model
{
    use HasFactory;

    protected $table = 'program_status_type';

    protected $fillable = [
        'name',
        'sequential_order',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function program_list(): HasMany
    {
        return $this->hasMany(Program::class, 'program_status_type_id', 'id');
    }

    // protected static function newFactory(): ProgramDurationTypeFactory
    // {
    //     return new ProgramDurationTypeFactory();
    // }
}
