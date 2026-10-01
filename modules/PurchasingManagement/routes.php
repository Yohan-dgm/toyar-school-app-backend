<?php

namespace Modules\PurchasingManagement;

use Illuminate\Support\Facades\Route;
use Modules\PurchasingManagement\Intents\PurchaseOrder\CreatePurchaseOrder\CreatePurchaseOrderIntent;
use Modules\PurchasingManagement\Intents\PurchaseOrder\GetPurchaseOrderListData\GetPurchaseOrderListDataIntent;
use Modules\PurchasingManagement\Intents\PurchaseOrder\UpdatePurchaseOrder\UpdatePurchaseOrderIntent;
use Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem\CreatePurchaseOrderItemIntent;
use Modules\PurchasingManagement\Intents\PurchaseOrderItem\GetPurchaseOrderItemListData\GetPurchaseOrderItemListDataIntent;
use Modules\PurchasingManagement\Intents\PurchaseRequestNote\CreatePurchaseRequestNote\CreatePurchaseRequestNoteIntent;
use Modules\PurchasingManagement\Intents\PurchaseRequestNote\GetPurchaseRequestNoteListData\GetPurchaseRequestNoteListDataIntent;
use Modules\PurchasingManagement\Intents\PurchaseRequestNote\UpdatePurchaseRequestNote\UpdatePurchaseRequestNoteIntent;
use Modules\PurchasingManagement\Intents\PurchaseRequestNoteStatus\CreatePurchaseRequestNoteStatus\CreatePurchaseRequestNoteStatusIntent;
use Modules\PurchasingManagement\Intents\ServicesReceivedNote\CreateServicesReceivedNote\CreateServicesReceivedNoteIntent;
use Modules\PurchasingManagement\Intents\ServicesReceivedNote\GetServicesReceivedNoteListData\GetServicesReceivedNoteListDataIntent;
use Modules\PurchasingManagement\Intents\ServicesReceivedNote\UpdateServicesReceivedNote\UpdateServicesReceivedNoteIntent;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem\CreateServicesReceivedNoteItemIntent;
use Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\GetServicesReceivedNoteItemListData\GetServicesReceivedNoteItemListDataIntent;
use Modules\PurchasingManagement\Intents\Supplier\CreateSupplier\CreateSupplierIntent;
use Modules\PurchasingManagement\Intents\Supplier\GetSupplierListData\GetSupplierListDataIntent;
use Modules\PurchasingManagement\Intents\Supplier\UpdateSupplier\UpdateSupplierIntent;

// PRN
Route::prefix('purchase-request-note')->group(function () {
    Route::middleware('auth:web')->post('/create-purchase-request-note', CreatePurchaseRequestNoteIntent::class)->name('purchase-request-note.create-purchase-request-note');
    Route::middleware('auth:web')->post('/update-purchase-request-note', UpdatePurchaseRequestNoteIntent::class)->name('purchase-request-note.update-purchase-request-note');
    Route::middleware('auth:web')->post('/get-purchase-request-note-list-data', GetPurchaseRequestNoteListDataIntent::class)->name('purchase-request-note.get-purchase-request-note-list-data');
});
Route::prefix('purchase-request-note-status')->group(function () {
    Route::middleware('auth:web')->post('/create-purchase-request-note-status', CreatePurchaseRequestNoteStatusIntent::class)->name('purchase-request-note.create-purchase-request-note-status');
});

// PO
Route::prefix('purchase-order')->group(function () {
    Route::middleware('auth:web')->post('/create-purchase-order', CreatePurchaseOrderIntent::class)->name('purchase-order.create-purchase-order');
    Route::middleware('auth:web')->post('/update-purchase-order', UpdatePurchaseOrderIntent::class)->name('purchase-order.update-purchase-order');
    Route::middleware('auth:web')->post('/get-purchase-order-list-data', GetPurchaseOrderListDataIntent::class)->name('purchase-order.get-purchase-order-list-data');
});

// PO Item
Route::prefix('purchase-order-item')->group(function () {
    Route::middleware('auth:web')->post('/create-purchase-order-item', CreatePurchaseOrderItemIntent::class)->name('purchase-order-item.create-purchase-order-item');
    Route::middleware('auth:web')->post('/get-purchase-order-item-list-data', GetPurchaseOrderItemListDataIntent::class)->name('purchase-order-item.get-purchase-order-item-list-data');
});

// PO
Route::prefix('services-received-note')->group(function () {
    Route::middleware('auth:web')->post('/create-services-received-note', CreateServicesReceivedNoteIntent::class)->name('services-received-note.create-services-received-note');
    Route::middleware('auth:web')->post('/update-services-received-note', UpdateServicesReceivedNoteIntent::class)->name('services-received-note.update-services-received-note');
    Route::middleware('auth:web')->post('/get-services-received-note-list-data', GetServicesReceivedNoteListDataIntent::class)->name('services-received-note.get-services-received-note-list-data');
});

// PO Item
Route::prefix('services-received-note-item')->group(function () {
    Route::middleware('auth:web')->post('/create-services-received-note-item', CreateServicesReceivedNoteItemIntent::class)->name('services-received-note-item.create-services-received-note-item');
    Route::middleware('auth:web')->post('/get-services-received-note-item-list-data', GetServicesReceivedNoteItemListDataIntent::class)->name('services-received-note-item.get-services-received-note-item-list-data');
});

// supplier
Route::prefix('supplier')->group(function () {
    Route::middleware('auth:web')->post('/create-supplier', CreateSupplierIntent::class)->name('supplier.create-supplier');
    Route::middleware('auth:web')->post('/update-supplier', UpdateSupplierIntent::class)->name('supplier.update-supplier');
    Route::middleware('auth:web')->post('/get-supplier-list-data', GetSupplierListDataIntent::class)->name('supplier.get-supplier-list-data');
});
