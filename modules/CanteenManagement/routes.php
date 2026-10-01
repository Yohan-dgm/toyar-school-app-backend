<?php

namespace Modules\CanteenManagement;

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\CanteenManagement\Intents\CanteenOrder\CancelCanteenOrder\CancelCanteenOrderIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\CompleteAllPendingCanteenOrders\CompleteAllPendingCanteenOrdersIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\CreateCanteenOrder\CreateCanteenOrderIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\GetCanteenOrderListData\GetCanteenOrderListDataIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\GetMyCanteenOrderListData\GetMyCanteenOrderListDataIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\GetTodayMealOrderSummary\GetTodayMealOrderSummaryIntent;
use Modules\CanteenManagement\Intents\CanteenOrder\UpdateCanteenOrderStatus\UpdateCanteenOrderStatusIntent;
use Modules\CanteenManagement\Intents\MealPlan\CreateMealPlan\CreateMealPlanIntent;
use Modules\CanteenManagement\Intents\MealPlan\DeleteMealPlan\DeleteMealPlanIntent;
use Modules\CanteenManagement\Intents\MealPlan\GetActiveMealPlanListData\GetActiveMealPlanListDataIntent;
use Modules\CanteenManagement\Intents\MealPlan\GetMealPlanListData\GetMealPlanListDataIntent;
use Modules\CanteenManagement\Intents\MealPlan\UpdateMealPlan\UpdateMealPlanIntent;

// MealPlan (educator-managed catalog: image, title, price, stock)
Route::prefix('meal-plan')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-meal-plan', CreateMealPlanIntent::class)->name('meal-plan.create-meal-plan');
    Route::middleware(AuthGuard::class)->post('/update-meal-plan', UpdateMealPlanIntent::class)->name('meal-plan.update-meal-plan');
    Route::middleware(AuthGuard::class)->post('/delete-meal-plan', DeleteMealPlanIntent::class)->name('meal-plan.delete-meal-plan');
    Route::middleware(AuthGuard::class)->post('/get-meal-plan-list-data', GetMealPlanListDataIntent::class)->name('meal-plan.get-meal-plan-list-data');
    Route::middleware(AuthGuard::class)->post('/get-active-meal-plan-list-data', GetActiveMealPlanListDataIntent::class)->name('meal-plan.get-active-meal-plan-list-data');
});

// CanteenOrder (parent-placed orders against the meal plan catalog)
Route::prefix('canteen-order')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-canteen-order', CreateCanteenOrderIntent::class)->name('canteen-order.create-canteen-order');
    Route::middleware(AuthGuard::class)->post('/cancel-canteen-order', CancelCanteenOrderIntent::class)->name('canteen-order.cancel-canteen-order');
    Route::middleware(AuthGuard::class)->post('/get-my-canteen-order-list-data', GetMyCanteenOrderListDataIntent::class)->name('canteen-order.get-my-canteen-order-list-data');
    Route::middleware(AuthGuard::class)->post('/get-canteen-order-list-data', GetCanteenOrderListDataIntent::class)->name('canteen-order.get-canteen-order-list-data');
    Route::middleware(AuthGuard::class)->post('/update-canteen-order-status', UpdateCanteenOrderStatusIntent::class)->name('canteen-order.update-canteen-order-status');
    Route::middleware(AuthGuard::class)->post('/complete-all-pending-canteen-orders', CompleteAllPendingCanteenOrdersIntent::class)->name('canteen-order.complete-all-pending-canteen-orders');
    Route::middleware(AuthGuard::class)->post('/get-today-meal-order-summary', GetTodayMealOrderSummaryIntent::class)->name('canteen-order.get-today-meal-order-summary');
});
