<?php

namespace Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User_type extends Model
{
    use HasFactory;

    protected $table = 'user_type';

    protected $fillable = [
        'name',
    ];

    public $timestamps = true;

    public function user_list(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_user_type_pivot', 'user_type_id', 'user_id');
    }

    // protected static function newFactory(): CurriculumTypeFactory
    // {
    //     return new CurriculumTypeFactory();
    // }
}
