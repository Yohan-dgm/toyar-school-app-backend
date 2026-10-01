<?php

namespace Modules\ActivityFeedManagement\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityFeedNotificationSetting extends Model
{
    protected $table = 'activity_feed_notification_settings';

    protected $fillable = [
        'section',
        'is_enabled',
        'updated_by',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public $timestamps = true;

    /**
     * Whether push notifications are enabled for the given section
     * (e.g. 'school_post', 'student_post', 'class_post').
     * Fails open (true) if no row exists for the section yet.
     */
    public static function isEnabled(string $section): bool
    {
        $value = static::where('section', $section)->value('is_enabled');

        return $value === null ? true : (bool) $value;
    }
}
