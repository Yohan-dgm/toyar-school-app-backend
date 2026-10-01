<?php

namespace Modules\CanteenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class CanteenMealPlan extends Model
{
    use HasFactory;

    protected $table = "canteen_meal_plan";

    protected $fillable = [
        "title",
        "description",
        "price",
        "quantity_available",
        "image_path",
        "is_active",
        "created_by",
        "updated_by",
    ];
    public $timestamps = true;

    protected $casts = [
        "price" => "decimal:2",
        "quantity_available" => "integer",
        "is_active" => "boolean",
    ];

    protected $appends = ["image_url"];

    public function getImageUrlAttribute(): ?string
    {
        // Explicitly use the "public" disk - the app's default disk
        // (FILESYSTEM_DISK) is "local", which has no configured URL and
        // would otherwise make Storage::url() fall back to a host-relative
        // path with no domain.
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
}
