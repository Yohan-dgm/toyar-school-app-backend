<?php

namespace Modules\CalendarManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Models\User;

class Event extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'event';

    protected $fillable = [
        'title',
        'event_category_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'description',
        'visibility_type',
        'is_approved',
        'request_visibility_type',
        'approved_by',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function event_category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    // factory
    // protected static function newFactory(): EventFactory
    // {
    //     return new EventFactory();
    // }
}
