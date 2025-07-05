<?php

use App\Http\Controllers\QuickDataHackController;
use App\Http\Controllers\ReportHandlerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\AccountManagement\Models\ReceiptVoucherAttachment;
use Modules\AccountManagement\Models\SupplierBillAttachment;
use Modules\StudentManagement\Models\StudentAttachment;

Route::get('/report-designer-9889', function () {
    return view('report-designer-9889');
});
Route::prefix('api/system-entity-management/system-entity-management')->group(function () {
    Route::middleware('auth:web')->post('/get-is-system-update-pending-data', function (Request $request) {
        return response()->json(
            [
                "status" => "successful",
                "message" => "",
                "data" => null,
                "metadata" => null,
            ],
            200
        );
    });
    Route::middleware('auth:web')->post('/update-is-system-update-pending', function (Request $request) {
        DB::table('user')->where('id', $request->user()->id)->update(['is_system_update_pending' => false]);
        return response()->json(
            [
                "status" => "successful",
                "message" => "",
                "data" => null,
                "metadata" => null,
            ],
            200
        );
    });
});


/*//////////////////////////////////////////////////////////////////////////////
Root Blank Page
*/ /////////////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    return view('welcome');
});

/*//////////////////////////////////////////////////////////////////////////////
Quick Data Hacks
*/ /////////////////////////////////////////////////////////////////////////////
// Route::get('/quick-data-hack/assign-school-house-to-student', [QuickDataHackController::class, 'assignSchoolHouseToStudent']);
// Route::get('/quick-data-hack/attach-user-type-to-user', [QuickDataHackController::class, 'attachUserTypeToUser']);
// Route::get('/quick-data-hack/attach-grade-level-class-to-educator', [QuickDataHackController::class, 'attachGradeLevelClassToEducator']);
// Route::get('/quick-data-hack/change-password', [QuickDataHackController::class, 'changePassword']);
// Route::get('/quick-data-hack/migrate-old-receipt-vouchers', [QuickDataHackController::class, 'migrateOldReceiptVouchers']);
// Route::get('/quick-data-hack/create-student-supply-notes', [QuickDataHackController::class, 'createStudentSupplyNotes']);
// Route::get('/quick-data-hack/assign-calling-name-to-student', [QuickDataHackController::class, 'assignCallingNameToStudent']);
Route::get('/quick-data-hack/update-term-fee-complete-status', [QuickDataHackController::class, 'updateTermFeeCompleteStatus']);
Route::get('/quick-data-hack/insert-term-fee-invoices', [QuickDataHackController::class, 'insertTermFeeInvoices']);
Route::get('/quick-data-hack/populate-joined-term-column-in-student-table', [QuickDataHackController::class, 'populateJoinedTermColumnInStudentTable']);
Route::get('/quick-data-hack/populate-term-fee-payment-table', [QuickDataHackController::class, 'populateTermFeePaymentTable']);
Route::get('/quick-data-hack/attach-term-fee-invoice-to-term-fee-payment-table', [QuickDataHackController::class, 'attachTermFeeInvoiceToTermFeePaymentTable']);
// Route::get('/quick-data-hack/insert-sport-fee-invoices', [QuickDataHackController::class, 'insertSportFeeInvoices']);
// Route::get('/quick-data-hack/update-sport-fee-invoice-recipt-voucher-link-data', [QuickDataHackController::class, 'updateSportFeeInvoiceReciptVoucherLinkData']);
// Route::get('/quick-data-hack/insert-admission-fee-invoices', [QuickDataHackController::class, 'insertAdmissionFeeInvoices']);
// Route::get('/quick-data-hack/update-admission-fee-recipt-voucher-link-data', [QuickDataHackController::class, 'updateAdmissionFeeReciptVoucherLinkData']);
// Route::get('/quick-data-hack/update-admission-fee-invoice-complete-status', [QuickDataHackController::class, 'updateAdmissionFeeInvoiceCompleteStatus']);
// Route::get('/quick-data-hack/insert-refundable-deposits', [QuickDataHackController::class, 'insertRefundableDeposits']);
// Route::get('/quick-data-hack/update-refunduble-deposit-old-data', [QuickDataHackController::class, 'updateRefundubleDepositOldData']);
// Route::get('/quick-data-hack/update-refundable-deposit-complete-status', [QuickDataHackController::class, 'updateRefundableDepositCompleteStatus']);
Route::get('/quick-data-hack/overpaid-term-fee-invoice-list', [QuickDataHackController::class, 'overpaidTermFeeInvoiceList']);


/*//////////////////////////////////////////////////////////////////////////////
Attachments
*/ /////////////////////////////////////////////////////////////////////////////
function renderAttachment($path, $attachment)
{
    if (str_contains($attachment->mime_type, 'image')) {
        return response()->download(
            storage_path($path),
            $attachment->original_file_name,
            ['Content-Type' => $attachment->mime_type]
        );
    } else if (str_contains($attachment->mime_type, 'pdf')) {
        return response()->file(
            storage_path($path),
            [
                'Content-Type' => $attachment->mime_type,
                'Content-disposition' => 'filename="' . $attachment->original_file_name . '"'
            ]
        );
    } else {
        return response()->download(
            storage_path($path),
            $attachment->original_file_name,
            ['Content-Type' => $attachment->mime_type]
        );
    }
}
// get-receipt-voucher-attachment-data
Route::get('/get-receipt-voucher-attachment-data', function (Request $request) {
    $data = [];
    $data['receipt_voucher_attachment_id'] = $request->all()['receipt_voucher_attachment_id'];
    $receiptVoucherAttachment = ReceiptVoucherAttachment::find($data['receipt_voucher_attachment_id']);
    $path = "app/private/attachments/account-management/receipt-voucher/" . explode("-", $receiptVoucherAttachment->file_name)[0] . "/" . $receiptVoucherAttachment->file_name;
    return renderAttachment($path, $receiptVoucherAttachment);
});
// get-student-attachment-data
Route::get('/get-student-attachment-data', function (Request $request) {
    $data = [];
    $data['student_attachment_id'] = $request->all()['student_attachment_id'];
    $studentAttachment = StudentAttachment::find($data['student_attachment_id']);
    $path = "app/private/attachments/student-management/student/" . explode("-", $studentAttachment->file_name)[0] . "/" . $studentAttachment->file_name;
    return renderAttachment($path, $studentAttachment);
});
// get-supplier-bill-attachment-data
Route::get('/get-supplier-bill-attachment-data', function (Request $request) {
    $data = [];
    $data['supplier_bill_attachment_id'] = $request->all()['supplier_bill_attachment_id'];
    $supplierBillAttachment = SupplierBillAttachment::find($data['supplier_bill_attachment_id']);
    $path = "app/private/attachments/account-management/supplier-bill/" . explode("-", $supplierBillAttachment->file_name)[0] . "/" . $supplierBillAttachment->file_name;
    return renderAttachment($path, $supplierBillAttachment);
});

/*//////////////////////////////////////////////////////////////////////////////
Reports
*/ /////////////////////////////////////////////////////////////////////////////
Route::any('/report-handler', [ReportHandlerController::class, 'process']);

// get-receipt-voucher-data-report
Route::get('/get-receipt-voucher-data', function (Request $request) {
    $data = [];
    $data['receipt_voucher_id'] = $request->all()['receipt_voucher_id'];
    return view('get-receipt-voucher-data', $data);
});
Route::get('/get-receipt-voucher-data-report', function () {
    return view('get-receipt-voucher-data-report');
});
// get-exam-bill-data-report
Route::get('/get-exam-bill-data', function (Request $request) {
    $data = [];
    $data['exam_bill_id'] = $request->all()['exam_bill_id'];
    return view('get-exam-bill-data', $data);
});
Route::get('/get-exam-bill-data-report', function () {
    return view('get-exam-bill-data-report');
});
// get-income-note-data-report
Route::get('/get-income-note-data', function (Request $request) {
    $data = [];
    $data['income_note_id'] = $request->all()['income_note_id'];
    return view('get-income-note-data', $data);
});
Route::get('/get-income-note-data-report', function () {
    return view('get-income-note-data-report');
});
// get-purchase-order-data-report
Route::get('/get-purchase-order-data', function (Request $request) {
    $data = [];
    $data['purchase_order_id'] = $request->all()['purchase_order_id'];
    return view('get-purchase-order-data', $data);
});
Route::get('/get-purchase-order-data-report', function () {
    return view('get-purchase-order-data-report');
});
// get-admission-fee-invoice-data-report
Route::get('/get-admission-fee-invoice-data', function (Request $request) {
    $data = [];
    $data['admission_fee_invoice_id'] = $request->all()['admission_fee_invoice_id'];
    return view('get-admission-fee-invoice-data', $data);
});
Route::get('/get-admission-fee-invoice-data-report', function () {
    return view('get-admission-fee-invoice-data-report');
});
// get-refundable-deposit-data-report
Route::get('/get-refundable-deposit-data', function (Request $request) {
    $data = [];
    $data['refundable_deposit_id'] = $request->all()['refundable_deposit_id'];
    return view('get-refundable-deposit-data', $data);
});
Route::get('/get-refundable-deposit-data-report', function () {
    return view('get-refundable-deposit-data-report');
});
// get-sport-fee-invoice-data-report
Route::get('/get-sport-fee-invoice-data', function (Request $request) {
    $data = [];
    $data['sport_fee_invoice_id'] = $request->all()['sport_fee_invoice_id'];
    return view('get-sport-fee-invoice-data', $data);
});
Route::get('/get-sport-fee-invoice-data-report', function () {
    return view('get-sport-fee-invoice-data-report');
});
