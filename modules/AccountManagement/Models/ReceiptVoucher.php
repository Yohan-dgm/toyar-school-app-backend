<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Modules\AdmissionManagement\Models\Applicant;
use Modules\ExamManagement\Models\ExamPrivateCandidate;
use Modules\GeneralEntityManagement\Models\Bank;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class ReceiptVoucher extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'receipt_voucher';

    protected $fillable = [
        'receipt_party',
        'narration',
        'amount',
        'admission_fee_settlement',
        'refundable_deposit_settlement',
        'term_fee_settlement',
        'payment_method',
        'bank_deposit_date',
        'cash_received_date',
        'check_type',
        'check_number',
        'check_received_date',
        'check_date',
        'payment_received_date',
        //
        'student_id',
        'applicant_id',
        'exam_private_candidate_id',
        'private_candidate_id',
        'bank_account_id',
        'cash_account_id',
        'check_bank_id',
        'payment_received_by_id',
        'receipt_voucher_status_type_id',
        //
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
        //
        'old_bill_number',
        'remarks',
        'receipt_voucher_type',
        'exam_bill_id',
        'applicant_proforma_invoice_id',
        'material_bill_id',
        'term_fee_invoice_id',
        'admission_fee_invoice_id',
        'refundable_deposit_id',
        'sport_fee_invoice_id',
        'is_reconciliation_complete',
        'reconciliation_completed_at',
        'late_fee_charges',
        'sport_fee',
        'is_active',
        'deleted_by',
        'deleted_date',
        'is_deleted_reqested',
        'request_delete_receipt_voucher_id',
        'is_reconciled',
    ];

    public $timestamps = true;

    // relations
    public function receipt_voucher_attachment_list(): HasMany
    {
        return $this->hasMany(ReceiptVoucherAttachment::class, 'receipt_voucher_id', 'id');
    }

    public function request_delete_receipt_voucher_list(): HasMany
    {
        return $this->hasMany(RequestDeleteReceiptVoucher::class, 'receipt_voucher_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }

    public function exam_private_candidate(): BelongsTo
    {
        return $this->belongsTo(ExamPrivateCandidate::class, 'exam_private_candidate_id', 'id');
    }

    public function private_candidate(): BelongsTo
    {
        return $this->belongsTo(ExamPrivateCandidate::class, 'private_candidate_id', 'id');
    }

    public function request_delete_receipt_voucher(): BelongsTo
    {
        return $this->belongsTo(RequestDeleteReceiptVoucher::class, 'request_delete_receipt_voucher_id', 'id');
    }

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function cash_account(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class, 'cash_account_id', 'id');
    }

    public function check_bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'check_bank_id', 'id');
    }

    public function payment_received_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_received_by_id', 'id');
    }

    public function receipt_voucher_status_type(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucherStatusType::class, 'receipt_voucher_status_type_id', 'id');
    }

    public function exam_bill(): BelongsTo
    {
        return $this->belongsTo(ExamBill::class, 'exam_bill_id', 'id');
    }

    public function material_bill(): BelongsTo
    {
        return $this->belongsTo(MaterialBill::class, 'material_bill_id', 'id');
    }

    public function term_fee_payment_list(): HasMany
    {
        return $this->hasMany(TermFeePayment::class, 'term_fee_invoice_id', 'id');
    }

    public function admission_fee_invoice(): BelongsTo
    {
        return $this->belongsTo(AdmissionFeeInvoice::class, 'admission_fee_invoice_id', 'id');
    }

    public function refundable_deposit(): BelongsTo
    {
        return $this->belongsTo(RefundableDeposit::class, 'refundable_deposit_id', 'id');
    }

    public function cash_deposit_item_list(): HasMany
    {
        return $this->hasMany(CashDepositItem::class, 'receipt_voucher_id', 'id');
    }

    public function applicant_proforma_invoice(): BelongsTo
    {
        return $this->belongsTo(ApplicantProformaInvoice::class, 'applicant_proforma_invoice_id', 'id');
    }
}
