<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice\CreateAdmissionFeeInvoiceIntent;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\GetAdmissionFeeInvoiceListData\GetAdmissionFeeInvoiceListDataIntent;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\UpdateAdmissionFeeInvoice\UpdateAdmissionFeeInvoiceIntent;
use Modules\AccountManagement\Intents\ApplicantProformaInvoice\CreateApplicantProformaInvoice\CreateApplicantProformaInvoiceIntent;
use Modules\AccountManagement\Intents\ApplicantProformaInvoice\GetApplicantProformaInvoiceListData\GetApplicantProformaInvoiceListDataIntent;
use Modules\AccountManagement\Intents\BankReconcile\CreateBankReconcile\CreateBankReconcileIntent;
use Modules\AccountManagement\Intents\BankStatement\GetBankStatementListData\GetBankStatementListDataIntent;
use Modules\AccountManagement\Intents\CashDeposit\CreateCashDeposit\CreateCashDepositIntent;
use Modules\AccountManagement\Intents\CashDeposit\GetCashDepositListData\GetCashDepositListDataIntent;
use Modules\AccountManagement\Intents\CashDeposit\UploadCashDeposit\UploadCashDepositIntent;
use Modules\AccountManagement\Intents\ExamBill\CreateExamBill\CreateExamBillIntent;
use Modules\AccountManagement\Intents\ExamBill\GetExamBillListData\GetExamBillListDataIntent;
use Modules\AccountManagement\Intents\ExamBill\UpdateExamBill\UpdateExamBillIntent;
use Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem\CreateExamBillItemIntent;
use Modules\AccountManagement\Intents\ExamBillItem\GetExamBillItemListData\GetExamBillItemListDataIntent;
use Modules\AccountManagement\Intents\ExpenseCategory\CreateExpenseCategory\CreateExpenseCategoryIntent;
use Modules\AccountManagement\Intents\ExpenseCategory\GetExpenseCategoryListData\GetExpenseCategoryListDataIntent;
use Modules\AccountManagement\Intents\ExpenseCategory\UpdateExpenseCategory\UpdateExpenseCategoryIntent;
use Modules\AccountManagement\Intents\ExpenseNote\CreateExpenseNote\CreateExpenseNoteIntent;
use Modules\AccountManagement\Intents\ExpenseNote\GetExpenseNoteListData\GetExpenseNoteListDataIntent;
use Modules\AccountManagement\Intents\ExpenseNote\UpdateExpenseNote\UpdateExpenseNoteIntent;
use Modules\AccountManagement\Intents\ExpenseParty\CreateExpenseParty\CreateExpensePartyIntent;
use Modules\AccountManagement\Intents\ExpenseParty\GetExpensePartyListData\GetExpensePartyListDataIntent;
use Modules\AccountManagement\Intents\ExpenseParty\UpdateExpenseParty\UpdateExpensePartyIntent;
use Modules\AccountManagement\Intents\ExpenseType\CreateExpenseType\CreateExpenseTypeIntent;
use Modules\AccountManagement\Intents\ExpenseType\GetExpenseTypeListData\GetExpenseTypeListDataIntent;
use Modules\AccountManagement\Intents\ExpenseType\UpdateExpenseType\UpdateExpenseTypeIntent;
use Modules\AccountManagement\Intents\GeneralBill\CreateGeneralBill\CreateGeneralBillIntent;
use Modules\AccountManagement\Intents\GeneralBill\GetGeneralBillListData\GetGeneralBillListDataIntent;
use Modules\AccountManagement\Intents\GeneralBill\UpdateGeneralBill\UpdateGeneralBillIntent;
use Modules\AccountManagement\Intents\IncomeCategory\CreateIncomeCategory\CreateIncomeCategoryIntent;
use Modules\AccountManagement\Intents\IncomeCategory\GetIncomeCategoryListData\GetIncomeCategoryListDataIntent;
use Modules\AccountManagement\Intents\IncomeCategory\UpdateIncomeCategory\UpdateIncomeCategoryIntent;
use Modules\AccountManagement\Intents\IncomeNote\CreateIncomeNote\CreateIncomeNoteIntent;
use Modules\AccountManagement\Intents\IncomeNote\GetIncomeNoteListData\GetIncomeNoteListDataIntent;
use Modules\AccountManagement\Intents\IncomeNote\UpdateIncomeNote\UpdateIncomeNoteIntent;
use Modules\AccountManagement\Intents\IncomeParty\CreateIncomeParty\CreateIncomePartyIntent;
use Modules\AccountManagement\Intents\IncomeParty\GetIncomePartyListData\GetIncomePartyListDataIntent;
use Modules\AccountManagement\Intents\IncomeParty\UpdateIncomeParty\UpdateIncomePartyIntent;
use Modules\AccountManagement\Intents\IncomeType\CreateIncomeType\CreateIncomeTypeIntent;
use Modules\AccountManagement\Intents\IncomeType\GetIncomeTypeListData\GetIncomeTypeListDataIntent;
use Modules\AccountManagement\Intents\IncomeType\UpdateIncomeType\UpdateIncomeTypeIntent;
use Modules\AccountManagement\Intents\ItemRate\CreateItemRate\CreateItemRateIntent;
use Modules\AccountManagement\Intents\ItemRateStatus\CreateItemRateStatus\CreateItemRateStatusIntent;
use Modules\AccountManagement\Intents\MaterialBill\CreateMaterialBill\CreateMaterialBillIntent;
use Modules\AccountManagement\Intents\MaterialBill\GetMaterialBillListData\GetMaterialBillListDataIntent;
use Modules\AccountManagement\Intents\MaterialBill\UpdateMaterialBill\UpdateMaterialBillIntent;
use Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem\CreateMaterialBillItemIntent;
use Modules\AccountManagement\Intents\MaterialBillItem\GetMaterialBillItemListData\GetMaterialBillItemListDataIntent;
use Modules\AccountManagement\Intents\PayableAccount\CreatePayableAccount\CreatePayableAccountIntent;
use Modules\AccountManagement\Intents\PayableAccount\GetPayableAccountListData\GetPayableAccountListDataIntent;
use Modules\AccountManagement\Intents\PayableAccount\UpdatePayableAccount\UpdatePayableAccountIntent;
use Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlan\CreatePaymentPlanIntent;
use Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlanStatus\CreatePaymentPlanStatusIntent;
use Modules\AccountManagement\Intents\PaymentVoucher\CreatePaymentVoucher\CreatePaymentVoucherIntent;
use Modules\AccountManagement\Intents\PaymentVoucher\GetPaymentVoucherListData\GetPaymentVoucherListDataIntent;
use Modules\AccountManagement\Intents\PaymentVoucher\UpdatePaymentVoucher\UpdatePaymentVoucherIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection\CreateInitialSectionIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\DeleteReceiptVoucher\DeleteReceiptVoucherIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData\GetReceiptVoucherListDataIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher\RequestDeleteReceiptVoucherIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\UpdateInitialSection\UpdateInitialSectionIntent;
use Modules\AccountManagement\Intents\ReceivableAccount\CreateReceivableAccount\CreateReceivableAccountIntent;
use Modules\AccountManagement\Intents\ReceivableAccount\GetReceivableAccountListData\GetReceivableAccountListDataIntent;
use Modules\AccountManagement\Intents\ReceivableAccount\UpdateReceivableAccount\UpdateReceivableAccountIntent;
use Modules\AccountManagement\Intents\ReceivableDashboard\CreateReceivableDashboard\CreateReceivableDashboardIntent;
use Modules\AccountManagement\Intents\ReceivableDashboard\GetReceivableDashboardListData\GetReceivableDashboardListDataIntent;
use Modules\AccountManagement\Intents\ReceivableDashboard\UpdateReceivableDashboard\UpdateReceivableDashboardIntent;
use Modules\AccountManagement\Intents\RefundableDeposit\CreateRefundableDeposit\CreateRefundableDepositIntent;
use Modules\AccountManagement\Intents\RefundableDeposit\GetRefundableDepositListData\GetRefundableDepositListDataIntent;
use Modules\AccountManagement\Intents\RefundableDeposit\UpdateRefundableDeposit\UpdateRefundableDepositIntent;
use Modules\AccountManagement\Intents\SchoolFee\GetSchoolFeeListData\GetSchoolFeeListDataIntent;
use Modules\AccountManagement\Intents\ServiceBill\CreateServiceBill\CreateServiceBillIntent;
use Modules\AccountManagement\Intents\ServiceBill\GetServiceBillListData\GetServiceBillListDataIntent;
use Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice\CreateSportFeeInvoiceIntent;
use Modules\AccountManagement\Intents\SportFeeInvoice\GetSportFeeInvoiceListData\GetSportFeeInvoiceListDataIntent;
use Modules\AccountManagement\Intents\SportFeeInvoice\UpdateSportFeeInvoice\UpdateSportFeeInvoiceIntent;
use Modules\AccountManagement\Intents\StudentBillsData\GetStudentBillsData\GetStudentBillsDataIntent;
use Modules\AccountManagement\Intents\SupplierBill\CreateSupplierBill\CreateSupplierBillIntent;
use Modules\AccountManagement\Intents\SupplierBill\GetSupplierBillListData\GetSupplierBillListDataIntent;
use Modules\AccountManagement\Intents\SupplierBill\UpdateSupplierBill\UpdateSupplierBillIntent;
use Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice\CreateTermFeeInvoiceIntent;
use Modules\AccountManagement\Intents\TermFeeInvoice\GetTermFeeInvoiceListData\GetTermFeeInvoiceListDataIntent;
use Modules\AccountManagement\Intents\TermFeeInvoice\UpdateTermFeeInvoice\UpdateTermFeeInvoiceIntent;
use Modules\AccountManagement\Intents\StudentPendingInvoice\GetStudentPendingInvoiceListData\GetStudentPendingInvoiceListDataIntent;
use Modules\AccountManagement\Intents\PaymentGateway\InitiatePaymentSession\InitiatePaymentSessionIntent;
use Modules\AccountManagement\Intents\PaymentGateway\CompletePayment\CompletePaymentIntent;
use Modules\AccountManagement\Intents\PaymentGateway\GetMyPaymentHistory\GetMyPaymentHistoryIntent;
use Modules\AccountManagement\Intents\PaymentGateway\GetPaymentGatewayStatus\GetPaymentGatewayStatusIntent;
use Modules\AccountManagement\Intents\PaymentGateway\GetPaymentReceipt\GetPaymentReceiptDataIntent;

// Account Management API Routes
Route::group(['middleware' => AuthGuard::class], function () {

    // Receivable Dashboard Management - Full CRUD
    Route::post('receivable-dashboard/create', CreateReceivableDashboardIntent::class);
    Route::post('receivable-dashboard/list', GetReceivableDashboardListDataIntent::class);
    Route::post('receivable-dashboard/update', UpdateReceivableDashboardIntent::class);

    // Receivable Account Management - Full CRUD
    Route::post('receivable-account/create', CreateReceivableAccountIntent::class);
    Route::post('receivable-account/list', GetReceivableAccountListDataIntent::class);
    Route::post('receivable-account/update', UpdateReceivableAccountIntent::class);

    // Payable Account Management - Full CRUD
    Route::post('payable-account/create', CreatePayableAccountIntent::class);
    Route::post('payable-account/list', GetPayableAccountListDataIntent::class);
    Route::post('payable-account/update', UpdatePayableAccountIntent::class);

    // Supplier Bill Management - Full CRUD
    Route::post('supplier-bill/create', CreateSupplierBillIntent::class);
    Route::post('supplier-bill/list', GetSupplierBillListDataIntent::class);
    Route::post('supplier-bill/update', UpdateSupplierBillIntent::class);

    // Income Party Management - Full CRUD
    Route::post('income-party/create', CreateIncomePartyIntent::class);
    Route::post('income-party/list', GetIncomePartyListDataIntent::class);
    Route::post('income-party/update', UpdateIncomePartyIntent::class);

    // Income Type Management - Full CRUD
    Route::post('income-type/create', CreateIncomeTypeIntent::class);
    Route::post('income-type/list', GetIncomeTypeListDataIntent::class);
    Route::post('income-type/update', UpdateIncomeTypeIntent::class);

    // Income Category Management - Full CRUD
    Route::post('income-category/create', CreateIncomeCategoryIntent::class);
    Route::post('income-category/list', GetIncomeCategoryListDataIntent::class);
    Route::post('income-category/update', UpdateIncomeCategoryIntent::class);

    // Income Note Management - Full CRUD
    Route::post('income-note/create', CreateIncomeNoteIntent::class);
    Route::post('income-note/list', GetIncomeNoteListDataIntent::class);
    Route::post('income-note/update', UpdateIncomeNoteIntent::class);

    // Expense Party Management - Full CRUD
    Route::post('expense-party/create', CreateExpensePartyIntent::class);
    Route::post('expense-party/list', GetExpensePartyListDataIntent::class);
    Route::post('expense-party/update', UpdateExpensePartyIntent::class);

    // Expense Type Management - Full CRUD
    Route::post('expense-type/create', CreateExpenseTypeIntent::class);
    Route::post('expense-type/list', GetExpenseTypeListDataIntent::class);
    Route::post('expense-type/update', UpdateExpenseTypeIntent::class);

    // Expense Category Management - Full CRUD
    Route::post('expense-category/create', CreateExpenseCategoryIntent::class);
    Route::post('expense-category/list', GetExpenseCategoryListDataIntent::class);
    Route::post('expense-category/update', UpdateExpenseCategoryIntent::class);

    // Expense Note Management - Full CRUD
    Route::post('expense-note/create', CreateExpenseNoteIntent::class);
    Route::post('expense-note/list', GetExpenseNoteListDataIntent::class);
    Route::post('expense-note/update', UpdateExpenseNoteIntent::class);

    // General Bill Management - Full CRUD
    Route::post('general-bill/create', CreateGeneralBillIntent::class);
    Route::post('general-bill/list', GetGeneralBillListDataIntent::class);
    Route::post('general-bill/update', UpdateGeneralBillIntent::class);

    // Receipt Voucher Management
    Route::post('receipt-voucher/list', GetReceiptVoucherListDataIntent::class);
    Route::post('receipt-voucher/create-initial-section', CreateInitialSectionIntent::class);
    Route::post('receipt-voucher/update-initial-section', UpdateInitialSectionIntent::class);
    Route::post('receipt-voucher/request-delete', RequestDeleteReceiptVoucherIntent::class);
    Route::post('receipt-voucher/delete', DeleteReceiptVoucherIntent::class);

    // Payment Voucher Management - Full CRUD
    Route::post('payment-voucher/create', CreatePaymentVoucherIntent::class);
    Route::post('payment-voucher/list', GetPaymentVoucherListDataIntent::class);
    Route::post('payment-voucher/update', UpdatePaymentVoucherIntent::class);

    // Item Rate Management
    Route::post('item-rate/create', CreateItemRateIntent::class);

    // Item Rate Status Management
    Route::post('item-rate-status/create', CreateItemRateStatusIntent::class);

    // Material Bill Management - Full CRUD
    Route::post('material-bill/list', GetMaterialBillListDataIntent::class);
    Route::post('material-bill/create', CreateMaterialBillIntent::class);
    Route::post('material-bill/update', UpdateMaterialBillIntent::class);

    // Material Bill Item Management
    Route::post('material-bill-item/list', GetMaterialBillItemListDataIntent::class);
    Route::post('material-bill-item/create', CreateMaterialBillItemIntent::class);

    // Service Bill Management
    Route::post('service-bill/list', GetServiceBillListDataIntent::class);
    Route::post('service-bill/create', CreateServiceBillIntent::class);

    // Exam Bill Management - Full CRUD
    Route::post('exam-bill/list', GetExamBillListDataIntent::class);
    Route::post('exam-bill/create', CreateExamBillIntent::class);
    Route::post('exam-bill/update', UpdateExamBillIntent::class);

    // Exam Bill Item Management
    Route::post('exam-bill-item/list', GetExamBillItemListDataIntent::class);
    Route::post('exam-bill-item/create', CreateExamBillItemIntent::class);

    // Payment Plan Management
    Route::post('payment-plan/create', CreatePaymentPlanIntent::class);
    Route::post('payment-plan/create-status', CreatePaymentPlanStatusIntent::class);

    // School Fee Management
    Route::post('school-fee/list', GetSchoolFeeListDataIntent::class);

    // Admission Fee Invoice Management - Full CRUD
    Route::post('admission-fee-invoice/list', GetAdmissionFeeInvoiceListDataIntent::class);
    Route::post('admission-fee-invoice/create', CreateAdmissionFeeInvoiceIntent::class);
    Route::post('admission-fee-invoice/update', UpdateAdmissionFeeInvoiceIntent::class);

    // Term Fee Invoice Management - Full CRUD
    Route::post('term-fee-invoice/list', GetTermFeeInvoiceListDataIntent::class);
    Route::post('term-fee-invoice/create', CreateTermFeeInvoiceIntent::class);
    Route::post('term-fee-invoice/update', UpdateTermFeeInvoiceIntent::class);
    // Refundable Deposit Management - Full CRUD
    Route::post('refundable-deposit/list', GetRefundableDepositListDataIntent::class);
    Route::post('refundable-deposit/create', CreateRefundableDepositIntent::class);
    Route::post('refundable-deposit/update', UpdateRefundableDepositIntent::class);

    // Sport Fee Invoice Management - Full CRUD
    Route::post('sport-fee-invoice/list', GetSportFeeInvoiceListDataIntent::class);
    Route::post('sport-fee-invoice/create', CreateSportFeeInvoiceIntent::class);
    Route::post('sport-fee-invoice/update', UpdateSportFeeInvoiceIntent::class);

    // Cash Deposit Management
    Route::post('cash-deposit/list', GetCashDepositListDataIntent::class);
    Route::post('cash-deposit/create', CreateCashDepositIntent::class);
    Route::post('cash-deposit/upload-slip', UploadCashDepositIntent::class);

    // Applicant Proforma Invoice Management
    Route::post('applicant-proforma-invoice/list', GetApplicantProformaInvoiceListDataIntent::class);
    Route::post('applicant-proforma-invoice/create', CreateApplicantProformaInvoiceIntent::class);

    // Bank Reconcile Management
    Route::post('bank-reconcile/create', CreateBankReconcileIntent::class);

    // Bank Statement Management
    Route::post('bank-statement/list', GetBankStatementListDataIntent::class);

    // Student Bills Data Management
    Route::post('student-bills-data/list', GetStudentBillsDataIntent::class);

    // Student Pending Invoice Management
    Route::post('student-pending-invoice/list', GetStudentPendingInvoiceListDataIntent::class);

    // Payment Gateway (HNB CyberSource)
    // Mutating/gateway-calling routes: rate limited to 5 requests per minute per user.
    Route::middleware('throttle:5,1')->group(function () {
        Route::post('payment/initiate-session', InitiatePaymentSessionIntent::class);
        Route::post('payment/complete', CompletePaymentIntent::class);
    });

    // Read-only history listing: more generous limit, separate from payment mutations
    // so normal pagination/browsing can't exhaust the payment-attempt quota.
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('payment/my-history', GetMyPaymentHistoryIntent::class);
        Route::post('payment/gateway-status', GetPaymentGatewayStatusIntent::class);
        Route::post('payment/receipt', GetPaymentReceiptDataIntent::class);
    });

});
