<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralBill extends Model
{
    protected $table = 'general_bill';

    protected $fillable = [
        'serial_number_prefix',
        'serial_number_current_year',
        'serial_number_digits',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function general_bill_attachment_list(): HasMany
    {
        return $this->hasMany(GeneralBillAttachment::class, 'general_bill_id', 'id');
    }
}
