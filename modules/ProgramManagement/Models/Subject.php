<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\EducatorManagement\Models\Educator;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';

    protected $fillable = [
        'name',
        'subject_code',
        'is_elective_subject',
        'program_id',
        'subject_type_id',
        'stream_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class, 'stream_id', 'id');
    }

    public function subject_type(): BelongsTo
    {
        return $this->belongsTo(SubjectType::class, 'subject_type_id', 'id');
    }
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function educator_list(): BelongsToMany
    {
        return $this->belongsToMany(Educator::class, 'educator_subject_pivot', 'subject_id', 'educator_id');
    }
    // protected static function newFactory(): SubjectFactory
    // {
    //     return new SubjectFactory();
    // }
}
