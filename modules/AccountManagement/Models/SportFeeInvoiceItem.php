<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class SportFeeInvoiceItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'sport_fee_invoice_item';

    protected $fillable = [
        'sport_fee_invoice_id',
        'school_fee_id',
        'description',
        'is_sport_fee_invoice_item_complete',
        'unit_price',
        'qty',
        'item_total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function sport_fee_invoice(): BelongsTo
    {
        return $this->belongsTo(SportFeeInvoice::class, 'sport_fee_invoice_id', 'id');
    }
}
