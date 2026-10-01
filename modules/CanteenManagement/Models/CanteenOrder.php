<?php

namespace Modules\CanteenManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class CanteenOrder extends Model
{
    use HasFactory;

    protected $table = "canteen_order";

    protected $fillable = [
        "student_id",
        "ordered_by",
        "order_date",
        "status",
        "total_amount",
        "created_by",
        "updated_by",
    ];
    public $timestamps = true;

    protected $casts = [
        "order_date" => "date",
        "total_amount" => "decimal:2",
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, "student_id", "id");
    }

    public function ordered_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, "ordered_by", "id");
    }

    public function items(): HasMany
    {
        return $this->hasMany(CanteenOrderItem::class, "canteen_order_id", "id");
    }
}
