<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\SystemEntityManagement\Models\Term;

class TermFeeInvoiceItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'term_fee_invoice_item';

    protected $fillable = [
        'term_fee_invoice_id',
        'grade_level_id',
        'term_id',
        'school_fee_id',
        'item_total',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations

    public function term_fee_invoice(): BelongsTo
    {
        return $this->belongsTo(TermFeeInvoice::class, 'term_fee_invoice_id', 'id');
    }

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function school_fee(): BelongsTo
    {
        return $this->belongsTo(SchoolFee::class, 'school_fee_id', 'id');
    }
}
