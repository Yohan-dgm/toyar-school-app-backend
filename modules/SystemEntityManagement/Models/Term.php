<?php

namespace Modules\SystemEntityManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\AccountManagement\Models\TermFeeInvoice;

class Term extends Model
{
    protected $table = 'term';

    protected $fillable = [
        'name',
        'school_year',
        'is_current_term',
        'start_date',
        'end_date',
        // 'is_active',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function school_fee_list(): HasMany
    {
        return $this->hasMany(SchoolFee::class, 'term_id', 'id');
    }

    public function term_fee_invoice_list(): HasMany
    {
        return $this->hasMany(TermFeeInvoice::class, 'term_id', 'id');
    }
}
