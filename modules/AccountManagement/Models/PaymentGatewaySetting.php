<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_settings';

    protected $fillable = [
        'gateway_name',
        'is_active',
        'maintenance_message',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $timestamps = true;
}
