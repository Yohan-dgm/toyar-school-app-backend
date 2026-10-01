<?php

use Illuminate\Support\Facades\Route;
use Modules\InventoryManagement\Intents\GoodsReceivedNote\CreateGoodsReceivedNote\CreateGoodsReceivedNoteIntent;
use Modules\InventoryManagement\Intents\GoodsReceivedNote\GetGoodsReceivedNoteListData\GetGoodsReceivedNoteListDataIntent;
use Modules\InventoryManagement\Intents\GoodsReceivedNote\UpdateGoodsReceivedNote\UpdateGoodsReceivedNoteIntent;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\CreateGoodsReceivedNoteItem\CreateGoodsReceivedNoteItemIntent;
use Modules\InventoryManagement\Intents\GoodsReceivedNoteItem\GetGoodsReceivedNoteItemListData\GetGoodsReceivedNoteItemListDataIntent;
use Modules\InventoryManagement\Intents\MaterialItem\CreateMaterialItem\CreateMaterialItemIntent;
use Modules\InventoryManagement\Intents\MaterialItem\GetMaterialItemListData\GetMaterialItemListDataIntent;
use Modules\InventoryManagement\Intents\MaterialItem\UpdateMaterialItem\UpdateMaterialItemIntent;
use Modules\InventoryManagement\Intents\MaterialItemCategory\CreateMaterialItemCategory\CreateMaterialItemCategoryIntent;
use Modules\InventoryManagement\Intents\MaterialItemCategory\GetMaterialItemCategoryListData\GetMaterialItemCategoryListDataIntent;
use Modules\InventoryManagement\Intents\MaterialItemCategory\UpdateMaterialItemCategory\UpdateMaterialItemCategoryIntent;
use Modules\InventoryManagement\Intents\MaterialItemSubCategory\CreateMaterialItemSubCategory\CreateMaterialItemSubCategoryIntent;
use Modules\InventoryManagement\Intents\MaterialItemSubCategory\GetMaterialItemSubCategoryListData\GetMaterialItemSubCategoryListDataIntent;
use Modules\InventoryManagement\Intents\MaterialItemType\CreateMaterialItemType\CreateMaterialItemTypeIntent;
use Modules\InventoryManagement\Intents\MaterialItemType\GetMaterialItemTypeListData\GetMaterialItemTypeListDataIntent;
use Modules\InventoryManagement\Intents\MaterialItemType\UpdateMaterialItemType\UpdateMaterialItemTypeIntent;
use Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem\CreateUnusableInventoryItemIntent;
use Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItemStatus\CreateUnusableInventoryItemStatusIntent;

// material-item-category
Route::prefix('material-item-category')->group(function () {
    Route::middleware('auth:web')->post('/create-material-item-category', CreateMaterialItemCategoryIntent::class)->name('material-item-category.create-material-item-category');
    Route::middleware('auth:web')->post('/update-material-item-category', UpdateMaterialItemCategoryIntent::class)->name('material-item-category.update-material-item-category');
    Route::middleware('auth:web')->post('/get-material-item-category-list-data', GetMaterialItemCategoryListDataIntent::class)->name('material-item-category.get-material-item-category-list-data');
});

// material-item-sub-category
Route::prefix('material-item-sub-category')->group(function () {
    Route::middleware('auth:web')->post('/create-material-item-sub-category', CreateMaterialItemSubCategoryIntent::class)->name('material-item-sub-category.create-material-item-sub-category');
    Route::middleware('auth:web')->post('/get-material-item-sub-category-list-data', GetMaterialItemSubCategoryListDataIntent::class)->name('material-item-sub-category.get-material-item-sub-category-list-data');
});

// material-item-type
Route::prefix('material-item-type')->group(function () {
    Route::middleware('auth:web')->post('/create-material-item-type', CreateMaterialItemTypeIntent::class)->name('material-item-type.create-material-item-type');
    Route::middleware('auth:web')->post('/update-material-item-type', UpdateMaterialItemTypeIntent::class)->name('material-item-type.update-material-item-type');
    Route::middleware('auth:web')->post('/get-material-item-type-list-data', GetMaterialItemTypeListDataIntent::class)->name('material-item-type.get-material-item-type-list-data');
});

// material-item
Route::prefix('material-item')->group(function () {
    Route::middleware('auth:web')->post('/create-material-item', CreateMaterialItemIntent::class)->name('material-item.create-material-item');
    Route::middleware('auth:web')->post('/update-material-item', UpdateMaterialItemIntent::class)->name('material-item.update-material-item');
    Route::middleware('auth:web')->post('/get-material-item-list-data', GetMaterialItemListDataIntent::class)->name('material-item.get-material-item-list-data');
});

// goods-received-note
Route::prefix('goods-received-note')->group(function () {
    Route::middleware('auth:web')->post('/create-goods-received-note', CreateGoodsReceivedNoteIntent::class)->name('goods-received-note.create-goods-received-note');
    Route::middleware('auth:web')->post('/update-goods-received-note', UpdateGoodsReceivedNoteIntent::class)->name('goods-received-note.update-goods-received-note');
    Route::middleware('auth:web')->post('/get-goods-received-note-list-data', GetGoodsReceivedNoteListDataIntent::class)->name('goods-received-note.get-goods-received-note-list-data');
});

// goods-received-note-item
Route::prefix('goods-received-note-item')->group(function () {
    Route::middleware('auth:web')->post('/create-goods-received-note-item', CreateGoodsReceivedNoteItemIntent::class)->name('goods-received-note-item.create-goods-received-note-item');
    Route::middleware('auth:web')->post('/get-goods-received-note-item-list-data', GetGoodsReceivedNoteItemListDataIntent::class)->name('goods-received-note-item.get-goods-received-note-item-list-data');
});

//create-unusable-inventory-item-status
Route::prefix('unusable-inventory-item')->group(function () {
    Route::middleware('auth:web')->post('/create-unusable-inventory-item', CreateUnusableInventoryItemIntent::class)->name('unusable-inventory-item.create-unusable-inventory-item');
    Route::middleware('auth:web')->post('/create-unusable-inventory-item-status', CreateUnusableInventoryItemStatusIntent::class)->name('unusable-inventory-item.create-unusable-inventory-item-status');
});
