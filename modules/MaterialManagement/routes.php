<?php

namespace Modules\MaterialManagement;

use Illuminate\Support\Facades\Route;
use Modules\MaterialManagement\Intents\MaterialIssueNote\CreateMaterialIssueNote\CreateMaterialIssueNoteIntent;
use Modules\MaterialManagement\Intents\MaterialRequestNote\CreateMaterialRequestNote\CreateMaterialRequestNoteIntent;

// PRN
Route::prefix('material-request-note')->group(function () {
    Route::middleware('auth:web')->post('/create-material-request-note', CreateMaterialRequestNoteIntent::class)->name('material-request-note.create-material-request-note');
    // Route::middleware('auth:web')->post('/get-material-request-note-list-data', GetPurchaseRequestNoteListDataIntent::class)->name('material-request-note.get-material-request-note-list-data');
});

// PO
Route::prefix('material-issue-note')->group(function () {
    Route::middleware('auth:web')->post('/create-material-issue-note', CreateMaterialIssueNoteIntent::class)->name('material-issue-note.create-material-issue-note');
    // Route::middleware('auth:web')->post('/get-material-issue-note-list-data', GetPurchaseRequestNoteListDataIntent::class)->name('material-issue-note.get-material-issue-note-list-data');
});
