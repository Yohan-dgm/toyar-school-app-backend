<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\ExamManagement\Models\ExamPrivateCandidate;
use Modules\ExamManagement\Models\ExamServiceCharge;
use Modules\StudentManagement\Models\Student;

class ExamBill extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_bill';

    protected $fillable = [
        //user
        'date',
        'bill_party',
        'student_id',
        'exam_private_candidate_id',
        'additional_service_charge',
        'exam_bill_discount',
        'bill_notes',
        'office_notes',

        //system
        'exam_subjects_total',
        'exam_service_charges_total',
        'subtotal',
        'total',
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function exam_bill_item_list(): HasMany
    {
        return $this->hasMany(ExamBillItem::class, 'exam_bill_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function exam_private_candidate(): BelongsTo
    {
        return $this->belongsTo(ExamPrivateCandidate::class, 'exam_private_candidate_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'exam_bill_id', 'id');
    }

    public function exam_service_charge_list(): BelongsToMany
    {
        return $this->belongsToMany(ExamServiceCharge::class, 'exam_bill_exam_service_charge_pivot', 'exam_bill_id', 'exam_service_charge_id');
    }
}
