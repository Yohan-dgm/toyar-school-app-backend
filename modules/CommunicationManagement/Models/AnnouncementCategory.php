<?php

namespace Modules\CommunicationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\UserManagement\Models\User;

class AnnouncementCategory extends Model
{
    use HasFactory;

    protected $table = 'announcement_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    // Relationships
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'category_id', 'id');
    }

    public function publishedAnnouncements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'category_id', 'id')
            ->where('status', 'published')
            ->whereNotNull('published_at');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeOrderedBySort($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    public function scopeWithAnnouncementCounts($query)
    {
        return $query->withCount([
            'announcements',
            'publishedAnnouncements',
        ]);
    }

    // Accessors
    public function getFormattedColorAttribute()
    {
        return $this->color ?: '#3b82f6';
    }

    public function getIconNameAttribute()
    {
        return $this->icon ?: 'megaphone';
    }

    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    // Helper methods
    public function getAnnouncementCount(): int
    {
        return $this->announcements()->count();
    }

    public function getPublishedAnnouncementCount(): int
    {
        return $this->publishedAnnouncements()->count();
    }

    public function hasAnnouncements(): bool
    {
        return $this->announcements()->exists();
    }

    public function canBeDeleted(): bool
    {
        return ! $this->hasAnnouncements();
    }

    public function getColorWithOpacity(float $opacity = 0.1): string
    {
        $color = $this->formatted_color;
        // Convert hex to rgba
        $rgb = sscanf($color, '#%02x%02x%02x');

        return "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, {$opacity})";
    }

    public static function getDefaultCategories(): array
    {
        return [
            ['name' => 'General', 'slug' => 'general', 'color' => '#3b82f6', 'icon' => 'megaphone'],
            ['name' => 'Academic', 'slug' => 'academic', 'color' => '#10b981', 'icon' => 'book-open'],
            ['name' => 'Events', 'slug' => 'events', 'color' => '#f59e0b', 'icon' => 'calendar'],
            ['name' => 'Emergency', 'slug' => 'emergency', 'color' => '#ef4444', 'icon' => 'exclamation-triangle'],
            ['name' => 'Administrative', 'slug' => 'administrative', 'color' => '#8b5cf6', 'icon' => 'clipboard-list'],
            ['name' => 'Sports', 'slug' => 'sports', 'color' => '#06b6d4', 'icon' => 'trophy'],
            ['name' => 'Health & Safety', 'slug' => 'health-safety', 'color' => '#84cc16', 'icon' => 'shield-check'],
            ['name' => 'Admissions', 'slug' => 'admissions', 'color' => '#ec4899', 'icon' => 'user-plus'],
        ];
    }
}
