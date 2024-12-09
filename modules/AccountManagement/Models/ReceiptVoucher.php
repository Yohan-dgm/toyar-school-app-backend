<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\AdmissionManagement\Models\Applicant;

class ReceiptVoucher extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'receipt_voucher';

    protected $fillable = [
        'receipt_party',
        'narration',
        'amount',
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
    ];

    public $timestamps = true;

    // relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
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
        return $this->belongsTo(Employee::class, 'payment_received_by_id', 'id');
    }

    public function receipt_voucher_status_type(): BelongsTo
    {
        return $this->belongsTo(ReceiptVoucherStatusType::class, 'receipt_voucher_status_type_id', 'id');
    }
    // factory
    // protected static function newFactory(): ReceiptVoucherFactory
    // {
    //     return new ReceiptVoucherFactory();
    // }
}
