<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class SupplierBillAttachment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'supplier_bill_attachment';

    protected $fillable = [
        'supplier_bill_id',
        'file_name',
        'original_file_name',
        'mime_type',
        //
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function supplier_bill(): BelongsTo
    {
        return $this->belongsTo(SupplierBill::class, 'supplier_bill_id', 'id');
    }
}
