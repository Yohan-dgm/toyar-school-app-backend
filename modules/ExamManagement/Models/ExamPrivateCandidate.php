<?php

namespace Modules\ExamManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\StudentManagement\Models\StudentAdmissionSource;

class ExamPrivateCandidate extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'exam_private_candidate';

    protected $fillable = [
        'gender',
        'full_name',
        'full_name_with_title',
        'phone',
        'email',
        'address',
        'student_admission_source_id',
        'student_admission_source_other',
        //
        'exam_private_candidate_number_prefix',
        'exam_private_candidate_number_current_year',
        'exam_private_candidate_number_digits',
        'exam_private_candidate_number',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    // relations
    public function student_admission_source(): BelongsTo
    {
        return $this->belongsTo(StudentAdmissionSource::class, 'student_admission_source_id', 'id');
    }

    public function receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'exam_private_candidate_id', 'id');
    }

    public function private_candidate_receipt_voucher_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucher::class, 'exam_private_candidate_id', 'id');
    }

    public function exam_bill_list(): HasMany
    {
        return $this->hasMany(ExamBill::class, 'exam_private_candidate_id', 'id');
    }
}
