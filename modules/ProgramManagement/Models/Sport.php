<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\EducatorManagement\Models\Educator;

class Sport extends Model
{
    use HasFactory;

    protected $table = 'sport';

    protected $fillable = [
        'name',
        'sport_code',
        'is_active',
        'sport_type',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // public function stream(): BelongsTo
    // {
    //     return $this->belongsTo(Stream::class, 'stream_id', 'id');
    // }

    // public function sport_type(): BelongsTo
    // {
    //     return $this->belongsTo(SportType::class, 'sport_type_id', 'id');
    // }
    // public function program(): BelongsTo
    // {
    //     return $this->belongsTo(Program::class, 'program_id', 'id');
    // }

    // public function educator_list(): BelongsToMany
    // {
    //     return $this->belongsToMany(Educator::class, 'educator_sport_pivot', 'sport_id', 'educator_id');
    // }
    // protected static function newFactory(): SportFactory
    // {
    //     return new SportFactory();
    // }

    public function student_list(): BelongsToMany
    {
        return $this->belongsToMany(Sport::class, 'student_sport_pivot', 'student_id', 'sport_id');
    }
}
