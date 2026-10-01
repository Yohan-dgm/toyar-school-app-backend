<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class StudentSupply extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'student_supply';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_supply_note_list(): HasMany
    {
        return $this->hasMany(StudentSupplyNote::class, 'student_supply_id', 'id');
    }
}
