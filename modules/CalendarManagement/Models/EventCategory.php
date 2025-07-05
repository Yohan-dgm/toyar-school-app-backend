<?php

namespace Modules\CalendarManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class EventCategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'event_category';

    protected $fillable = [
        'name',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function event_list(): HasMany
    {
        return $this->hasMany(Event::class, 'event_category_id', 'id');
    }
    // factory
    // protected static function newFactory(): EventFactory
    // {
    //     return new EventFactory();
    // }
}
