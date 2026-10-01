<?php

namespace Modules\CanteenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanteenOrderItem extends Model
{
    use HasFactory;

    protected $table = "canteen_order_item";

    protected $fillable = [
        "canteen_order_id",
        "meal_plan_id",
        "meal_plan_title",
        "unit_price",
        "quantity",
        "subtotal",
    ];
    public $timestamps = true;

    protected $casts = [
        "unit_price" => "decimal:2",
        "quantity" => "integer",
        "subtotal" => "decimal:2",
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(CanteenOrder::class, "canteen_order_id", "id");
    }

    public function meal_plan(): BelongsTo
    {
        return $this->belongsTo(CanteenMealPlan::class, "meal_plan_id", "id");
    }
}
