<?php

namespace Modules\AccountManagement;

use Illuminate\Support\Facades\Route;
use Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection\CreateInitialSectionIntent;
use Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData\GetReceiptVoucherListDataIntent;

// Receipt
Route::prefix('receipt-voucher')->group(function () {
    Route::middleware('auth:web')->post('/get-receipt-voucher-list-data', GetReceiptVoucherListDataIntent::class)->name('receipt-voucher.get-receipt-voucher-list-data');
    Route::middleware('auth:web')->post('/create-initial-section', CreateInitialSectionIntent::class)->name('receipt-voucher.create-initial-section');
});
