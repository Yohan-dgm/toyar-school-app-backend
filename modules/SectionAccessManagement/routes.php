<?php

namespace Modules\SectionAccessManagement;

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\SectionAccessManagement\Intents\GetGrantableUserList\GetGrantableUserListIntent;
use Modules\SectionAccessManagement\Intents\GetMySectionAccess\GetMySectionAccessIntent;
use Modules\SectionAccessManagement\Intents\GetSectionAccessListData\GetSectionAccessListDataIntent;
use Modules\SectionAccessManagement\Intents\GrantSectionAccess\GrantSectionAccessIntent;
use Modules\SectionAccessManagement\Intents\RevokeSectionAccess\RevokeSectionAccessIntent;

Route::prefix('section-access')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-my-section-access', GetMySectionAccessIntent::class)->name('section-access.get-my-section-access');
    Route::middleware(AuthGuard::class)->post('/grant-section-access', GrantSectionAccessIntent::class)->name('section-access.grant-section-access');
    Route::middleware(AuthGuard::class)->post('/revoke-section-access', RevokeSectionAccessIntent::class)->name('section-access.revoke-section-access');
    Route::middleware(AuthGuard::class)->post('/get-grantable-user-list', GetGrantableUserListIntent::class)->name('section-access.get-grantable-user-list');
    Route::middleware(AuthGuard::class)->post('/get-section-access-list-data', GetSectionAccessListDataIntent::class)->name('section-access.get-section-access-list-data');
});
