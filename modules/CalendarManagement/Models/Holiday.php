<?php

namespace Modules\CalendarManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Holiday extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'school_holiday';

    protected $fillable = [
        'title',
        'date',
        'description',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    // public function event_category(): BelongsTo
    // {
    //     return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    // }
    // factory
    // protected static function newFactory(): EventFactory
    // {
    //     return new EventFactory();
    // }
}
