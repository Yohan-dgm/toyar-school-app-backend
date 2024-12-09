<?php

namespace Modules\ProgramManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stream extends Model
{
    use HasFactory;

    protected $table = 'stream';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function subject_list(): HasMany
    {
        return $this->hasMany(Subject::class, 'stream_id', 'id');
    }

    // protected static function newFactory(): StreamFactory
    // {
    //     return new StreamFactory();
    // }
}
