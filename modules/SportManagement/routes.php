<?php

use Illuminate\Support\Facades\Route;
use Modules\SportManagement\Intents\StudentSport\AddStudentToSport\AddStudentToSportIntent;
use Modules\SportManagement\Intents\StudentSport\GetSportsByStudent\GetSportsByStudentIntent;
use Modules\SportManagement\Intents\StudentSport\GetStudentsBySport\GetStudentsBySportIntent;
use Modules\SportManagement\Intents\StudentSport\GetStudentSportRecords\GetStudentSportRecordsIntent;
use Modules\SportManagement\Intents\StudentSport\RemoveStudentFromSport\RemoveStudentFromSportIntent;
use Modules\SportManagement\Intents\StudentSport\UpdateStudentSport\UpdateStudentSportIntent;

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    // Add student to sport
    Route::post('/students/add', AddStudentToSportIntent::class);

    // Remove student from sport
    Route::delete('/students/{student_id}/sports/{sport_id}', RemoveStudentFromSportIntent::class);

    // Update student sport enrollment
    Route::put('/students/{student_id}/sports/{sport_id}', UpdateStudentSportIntent::class);

    // Get student sport enrollment history/records
    Route::get('/students/{student_id}/sports/history', GetStudentSportRecordsIntent::class);

    // Get all students in a specific sport
    Route::get('/sports/{sport_id}/students', GetStudentsBySportIntent::class);

    // Get all sports for a specific student
    Route::get('/students/{student_id}/sports', GetSportsByStudentIntent::class);
});
