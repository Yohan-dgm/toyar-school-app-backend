<?php

namespace Modules\AccountManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Modules\EmployeeManagement\Models\Employee;
use Modules\PurchasingManagement\Models\PurchaseOrder;

class PaymentVoucher extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'payment_voucher';

    protected $fillable = [
        'payment_voucher_type',
        'purchase_order_id',
        'expense_note_id',
        'amount',
        'narration',
        'payment_method',
        'cash_account_id',
        'cash_paid_date',
        'bank_account_id',
        'bank_transfer_date',
        'bank_transfer_reference_number',
        'check_type',
        'check_bank_account_id',
        'check_number',
        'check_issued_date',
        'check_date',
        'payment_issued_by_id',
        //
        'is_active',
        'payment_issued_date',
        'serial_number_prefix',
        'serial_number_digits',
        'serial_number_current_year',
        'serial_number_financial_year',
        'serial_number_suffix',
        'serial_number',
        'created_by',
        'updated_by',
        'is_reconciled',
    ];

    public $timestamps = true;

    // relations
    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function expense_note(): BelongsTo
    {
        return $this->belongsTo(ExpenseNote::class, 'expense_note_id', 'id');
    }

    public function cash_account(): BelongsTo
    {
        return $this->belongsTo(CashAccount::class, 'cash_account_id', 'id');
    }

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    public function check_bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'check_bank_account_id', 'id');
    }

    public function payment_issued_by(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'payment_issued_by_id', 'id');
    }
}
