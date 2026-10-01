<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\AcademicStaffManagement\Intents\ClassTeacher\CreateClassTeacher\CreateClassTeacherIntent;
use Modules\AcademicStaffManagement\Intents\ClassTeacher\UpdateClassTeacher\UpdateClassTeacherIntent;
use Modules\AcademicStaffManagement\Intents\ClassTeacher\DeleteClassTeacher\DeleteClassTeacherIntent;
use Modules\AcademicStaffManagement\Intents\ClassTeacher\GetClassTeacherList\GetClassTeacherListIntent;
use Modules\AcademicStaffManagement\Intents\SectionalHead\CreateSectionalHead\CreateSectionalHeadIntent;
use Modules\AcademicStaffManagement\Intents\SectionalHead\UpdateSectionalHead\UpdateSectionalHeadIntent;
use Modules\AcademicStaffManagement\Intents\SectionalHead\DeleteSectionalHead\DeleteSectionalHeadIntent;
use Modules\AcademicStaffManagement\Intents\SectionalHead\GetSectionalHeadList\GetSectionalHeadListIntent;
use Modules\AcademicStaffManagement\Intents\GetTeacherList\GetTeacherListIntent;

// Class Teacher Routes
Route::prefix('class-teacher')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create', CreateClassTeacherIntent::class)->name('class-teacher.create');
    Route::middleware(AuthGuard::class)->post('/update', UpdateClassTeacherIntent::class)->name('class-teacher.update');
    Route::middleware(AuthGuard::class)->post('/delete', DeleteClassTeacherIntent::class)->name('class-teacher.delete');
    Route::middleware(AuthGuard::class)->post('/list', GetClassTeacherListIntent::class)->name('class-teacher.list');
});

// Sectional Head Routes
Route::prefix('sectional-head')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create', CreateSectionalHeadIntent::class)->name('sectional-head.create');
    Route::middleware(AuthGuard::class)->post('/update', UpdateSectionalHeadIntent::class)->name('sectional-head.update');
    Route::middleware(AuthGuard::class)->post('/delete', DeleteSectionalHeadIntent::class)->name('sectional-head.delete');
    Route::middleware(AuthGuard::class)->post('/list', GetSectionalHeadListIntent::class)->name('sectional-head.list');
});

// Teacher List Routes
Route::prefix('teachers')->group(function () {
    Route::middleware(AuthGuard::class)->post('/list', GetTeacherListIntent::class)->name('teachers.list');
});
