<?php

namespace Modules\AdmissionManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\AccountManagement\Models\ServiceBill;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\SystemEntityManagement\Models\Term;

class Applicant extends Model
{
    protected $table = 'applicant';

    protected $fillable = [
        'full_name',
        'gender',
        'full_name_with_title',
        'date_of_birth',
        'nationality_id',
        'religion_id',
        'grade_level_id',
        'full_address',
        'phone',
        'email',
        'school_studied_before',
        'special_conditions',
        'applicant_number_prefix',
        'applicant_number_current_year',
        'applicant_number_digits',
        'applicant_number',
        'created_by',
        'updated_by',
        'has_converted_to_student',
        'approved_admission_fee',
        'approved_refundable_deposit',
        'approved_term_payment',
        'start_term_id',
    ];

    public $timestamps = true;

    public function grade_level(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id', 'id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'start_term_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'applicant_id', 'id');
    }

    public function material_bill_list(): HasMany
    {
        return $this->hasMany(MaterialBill::class, 'applicant_id', 'id');
    }

    public function service_bill_list(): HasMany
    {
        return $this->hasMany(ServiceBill::class, 'applicant_id', 'id');
    }
}
