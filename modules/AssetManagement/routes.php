<?php

use Illuminate\Support\Facades\Route;
use Modules\AssetManagement\Intents\AssetItem\CreateAssetItem\CreateAssetItemIntent;
use Modules\AssetManagement\Intents\AssetItem\GetAssetItemAggregatedListData\GetAssetItemAggregatedListDataIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CreateCurrentAssetItem\CreateCurrentAssetItemIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\CreateCurrentAssetItemCategory\CreateCurrentAssetItemCategoryIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\GetCurrentAssetItemCategoryListData\GetCurrentAssetItemCategoryListDataIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\UpdateCurrentAssetItemCategory\UpdateCurrentAssetItemCategoryIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\CreateCurrentAssetItemSubCategory\CreateCurrentAssetItemSubCategoryIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\GetCurrentAssetItemSubCategoryListData\GetCurrentAssetItemSubCategoryListDataIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\CreateCurrentAssetItemType\CreateCurrentAssetItemTypeIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\GetCurrentAssetItemTypeListData\GetCurrentAssetItemTypeListDataIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\UpdateCurrentAssetItemType\UpdateCurrentAssetItemTypeIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\GetCurrentAssetItemListData\GetCurrentAssetItemListDataIntent;
use Modules\AssetManagement\Intents\CurrentAssetItem\UpdateCurrentAssetItem\UpdateCurrentAssetItemIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\CreateFixedAssetItem\CreateFixedAssetItemIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\CreateFixedAssetItemCategory\CreateFixedAssetItemCategoryIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\GetFixedAssetItemCategoryListData\GetFixedAssetItemCategoryListDataIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\UpdateFixedAssetItemCategory\UpdateFixedAssetItemCategoryIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\CreateFixedAssetItemSubCategory\CreateFixedAssetItemSubCategoryIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\GetFixedAssetItemSubCategoryListData\GetFixedAssetItemSubCategoryListDataIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\CreateFixedAssetItemType\CreateFixedAssetItemTypeIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\GetFixedAssetItemTypeListData\GetFixedAssetItemTypeListDataIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\UpdateFixedAssetItemType\UpdateFixedAssetItemTypeIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\GetFixedAssetItemListData\GetFixedAssetItemListDataIntent;
use Modules\AssetManagement\Intents\FixedAssetItem\UpdateFixedAssetItem\UpdateFixedAssetItemIntent;

// asset-item
Route::prefix('asset-item')->group(function () {
    Route::middleware('auth:web')->post('/create-asset-item', CreateAssetItemIntent::class)->name('asset-item.create-asset-item');
    Route::middleware('auth:web')->post('/get-asset-item-aggregated-list-data', GetAssetItemAggregatedListDataIntent::class)->name('asset-item.get-asset-item-aggregated-list-data');
});

// fixed-asset-item-category
Route::prefix('fixed-asset-item-category')->group(function () {
    Route::middleware('auth:web')->post('/create-fixed-asset-item-category', CreateFixedAssetItemCategoryIntent::class)->name('fixed-asset-item-category.create-fixed-asset-item-category');
    Route::middleware('auth:web')->post('/update-fixed-asset-item-category', UpdateFixedAssetItemCategoryIntent::class)->name('fixed-asset-item-category.update-fixed-asset-item-category');
    Route::middleware('auth:web')->post('/get-fixed-asset-item-category-list-data', GetFixedAssetItemCategoryListDataIntent::class)->name('fixed-asset-item-category.get-fixed-asset-item-category-list-data');
});

// fixed-asset-item-sub-category
Route::prefix('fixed-asset-item-sub-category')->group(function () {
    Route::middleware('auth:web')->post('/create-fixed-asset-item-sub-category', CreateFixedAssetItemSubCategoryIntent::class)->name('fixed-asset-item-sub-category.create-fixed-asset-item-sub-category');
    Route::middleware('auth:web')->post('/get-fixed-asset-item-sub-category-list-data', GetFixedAssetItemSubCategoryListDataIntent::class)->name('fixed-asset-item-sub-category.get-fixed-asset-item-sub-category-list-data');
});

// fixed-asset-item-type
Route::prefix('fixed-asset-item-type')->group(function () {
    Route::middleware('auth:web')->post('/create-fixed-asset-item-type', CreateFixedAssetItemTypeIntent::class)->name('fixed-asset-item-type.create-fixed-asset-item-type');
    Route::middleware('auth:web')->post('/update-fixed-asset-item-type', UpdateFixedAssetItemTypeIntent::class)->name('fixed-asset-item-type.update-fixed-asset-item-type');
    Route::middleware('auth:web')->post('/get-fixed-asset-item-type-list-data', GetFixedAssetItemTypeListDataIntent::class)->name('fixed-asset-item-type.get-fixed-asset-item-type-list-data');
});

// fixed-asset-item
Route::prefix('fixed-asset-item')->group(function () {
    Route::middleware('auth:web')->post('/create-fixed-asset-item', CreateFixedAssetItemIntent::class)->name('fixed-asset-item.create-fixed-asset-item');
    Route::middleware('auth:web')->post('/update-fixed-asset-item', UpdateFixedAssetItemIntent::class)->name('fixed-asset-item.update-fixed-asset-item');
    Route::middleware('auth:web')->post('/get-fixed-asset-item-list-data', GetFixedAssetItemListDataIntent::class)->name('fixed-asset-item.get-fixed-asset-item-list-data');
});

// current-asset-item-category
Route::prefix('current-asset-item-category')->group(function () {
    Route::middleware('auth:web')->post('/create-current-asset-item-category', CreateCurrentAssetItemCategoryIntent::class)->name('current-asset-item-category.create-current-asset-item-category');
    Route::middleware('auth:web')->post('/update-current-asset-item-category', UpdateCurrentAssetItemCategoryIntent::class)->name('current-asset-item-category.update-current-asset-item-category');
    Route::middleware('auth:web')->post('/get-current-asset-item-category-list-data', GetCurrentAssetItemCategoryListDataIntent::class)->name('current-asset-item-category.get-current-asset-item-category-list-data');
});

// current-asset-item-sub-category
Route::prefix('current-asset-item-sub-category')->group(function () {
    Route::middleware('auth:web')->post('/create-current-asset-item-sub-category', CreateCurrentAssetItemSubCategoryIntent::class)->name('current-asset-item-sub-category.create-current-asset-item-sub-category');
    Route::middleware('auth:web')->post('/get-current-asset-item-sub-category-list-data', GetCurrentAssetItemSubCategoryListDataIntent::class)->name('current-asset-item-sub-category.get-current-asset-item-sub-category-list-data');
});

// current-asset-item-type
Route::prefix('current-asset-item-type')->group(function () {
    Route::middleware('auth:web')->post('/create-current-asset-item-type', CreateCurrentAssetItemTypeIntent::class)->name('current-asset-item-type.create-current-asset-item-type');
    Route::middleware('auth:web')->post('/update-current-asset-item-type', UpdateCurrentAssetItemTypeIntent::class)->name('current-asset-item-type.update-current-asset-item-type');
    Route::middleware('auth:web')->post('/get-current-asset-item-type-list-data', GetCurrentAssetItemTypeListDataIntent::class)->name('current-asset-item-type.get-current-asset-item-type-list-data');
});

// current-asset-item
Route::prefix('current-asset-item')->group(function () {
    Route::middleware('auth:web')->post('/create-current-asset-item', CreateCurrentAssetItemIntent::class)->name('current-asset-item.create-current-asset-item');
    Route::middleware('auth:web')->post('/update-current-asset-item', UpdateCurrentAssetItemIntent::class)->name('current-asset-item.update-current-asset-item');
    Route::middleware('auth:web')->post('/get-current-asset-item-list-data', GetCurrentAssetItemListDataIntent::class)->name('current-asset-item.get-current-asset-item-list-data');
});
