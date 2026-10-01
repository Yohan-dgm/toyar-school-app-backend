<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class PaymentGatewayOrder extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_orders';

    protected $fillable = [
        'order_reference',
        'user_id',
        'student_id',
        'invoice_type',
        'invoice_id',
        'amount',
        'currency',
        'service_fee_percentage',
        'service_fee_amount',
        'total_charged_amount',
        'status',
        'admin_status',
        'admin_approved_by',
        'admin_approved_at',
        'admin_notes',
        'transient_token',
        'cybersource_reference',
        'cybersource_decision',
        'receipt_voucher_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'admin_approved_at' => 'datetime',
        'amount' => 'decimal:2',
        'service_fee_percentage' => 'decimal:2',
        'service_fee_amount' => 'decimal:2',
        'total_charged_amount' => 'decimal:2',
    ];

    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin_approved_by_user()
    {
        return $this->belongsTo(User::class, 'admin_approved_by', 'id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
