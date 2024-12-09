<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubjectType extends Model
{
    use HasFactory;

    protected $table = 'subject_type';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function subject_list(): HasMany
    {
        return $this->hasMany(Program::class, 'subject_type_id', 'id');
    }

    // protected static function newFactory(): SubjectTypeFactory
    // {
    //     return new SubjectTypeFactory();
    // }
}
