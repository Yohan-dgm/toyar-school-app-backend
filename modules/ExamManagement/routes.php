<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\ExamManagement\Intents\ExamMarkSubject\CompleteEducatorEnterMark\CompleteEducatorEnterMarkIntent;
use Modules\ExamManagement\Intents\ExamMarkSubject\GetExamMarkSubjectListData\GetExamMarkSubjectListDataIntent;
use Modules\ExamManagement\Intents\ExamPrivateCandidate\CreateExamPrivateCandidate\CreateExamPrivateCandidateIntent;
use Modules\ExamManagement\Intents\ExamPrivateCandidate\GetExamPrivateCandidateListData\GetExamPrivateCandidateListDataIntent;
use Modules\ExamManagement\Intents\ExamPrivateCandidate\UpdateExamPrivateCandidate\UpdateExamPrivateCandidateIntent;
use Modules\ExamManagement\Intents\ExamQuiz\CreateExamQuiz\CreateExamQuizIntent;
use Modules\ExamManagement\Intents\ExamQuiz\GenerateExamReport\GenerateExamReportIntent;
use Modules\ExamManagement\Intents\ExamQuiz\GetExamQuizListData\GetExamQuizListDataIntent;
use Modules\ExamManagement\Intents\ExamQuizItem\GetExamQuizItemListData\GetExamQuizItemListDataIntent;
use Modules\ExamManagement\Intents\ExamServiceCharge\CreateExamServiceCharge\CreateExamServiceChargeIntent;
use Modules\ExamManagement\Intents\ExamServiceCharge\GetExamServiceChargeListData\GetExamServiceChargeListDataIntent;
use Modules\ExamManagement\Intents\ExamServiceCharge\UpdateExamServiceCharge\UpdateExamServiceChargeIntent;
use Modules\ExamManagement\Intents\ExamSubject\CreateExamSubject\CreateExamSubjectIntent;
use Modules\ExamManagement\Intents\ExamSubject\GetExamSubjectListData\GetExamSubjectListDataIntent;
use Modules\ExamManagement\Intents\ExamSubject\UpdateExamSubject\UpdateExamSubjectIntent;
use Modules\ExamManagement\Intents\ExamSubjectCategory\CreateExamSubjectCategory\CreateExamSubjectCategoryIntent;
use Modules\ExamManagement\Intents\ExamSubjectCategory\GetExamSubjectCategoryListData\GetExamSubjectCategoryListDataIntent;
use Modules\ExamManagement\Intents\ExamSubjectCategory\UpdateExamSubjectCategory\UpdateExamSubjectCategoryIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponent\CreateExamSubjectComponent\CreateExamSubjectComponentIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponent\GetExamSubjectComponentListData\GetExamSubjectComponentListDataIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponent\UpdateExamSubjectComponent\UpdateExamSubjectComponentIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponentType\CreateExamSubjectComponentType\CreateExamSubjectComponentTypeIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponentType\GetExamSubjectComponentTypeListData\GetExamSubjectComponentTypeListDataIntent;
use Modules\ExamManagement\Intents\ExamSubjectComponentType\UpdateExamSubjectComponentType\UpdateExamSubjectComponentTypeIntent;
use Modules\ExamManagement\Intents\ExamSubjectGroup\CreateExamSubjectGroup\CreateExamSubjectGroupIntent;
use Modules\ExamManagement\Intents\ExamSubjectGroup\GetExamSubjectGroupListData\GetExamSubjectGroupListDataIntent;
use Modules\ExamManagement\Intents\ExamSubjectGroup\UpdateExamSubjectGroup\UpdateExamSubjectGroupIntent;
use Modules\ExamManagement\Intents\SchedulingExamination\ApproveSchedulingExamination\ApproveSchedulingExaminationIntent;
use Modules\ExamManagement\Intents\SchedulingExamination\CreateSchedulingExamination\CreateSchedulingExaminationIntent;
use Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationListData\GetSchedulingExaminationListDataIntent;
use Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationSimpleListData\GetSchedulingExaminationSimpleListDataIntent;
use Modules\ExamManagement\Intents\SchedulingExamination\UpdateSchedulingExamination\UpdateSchedulingExaminationIntent;
use Modules\ExamManagement\Intents\SchedulingExaminationGrade\GetSchedulingExaminationGradeListData\GetSchedulingExaminationGradeListDataIntent;
use Modules\ExamManagement\Intents\StudentExamData\GetStudentExamData\GetStudentExamDataIntent;
use Modules\ExamManagement\Intents\StudentExamMark\GetStudentExamMarkListData\GetStudentExamMarkListDataIntent;
use Modules\ExamManagement\Intents\StudentExamMark\RemovableSubjectStudentData\RemovableSubjectStudentDataIntent;
use Modules\ExamManagement\Intents\StudentExamMark\UpdateStudentExamMark\UpdateStudentExamMarkIntent;
use Modules\ExamManagement\Intents\StudentExamReport\GenerateExamReport\GenerateExamReportIntent as GenerateExamReportGenerateExamReportIntent;
use Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportBySchedulingExaminationId\GetStudentExamReportBySchedulingExaminationIdIntent;
use Modules\ExamManagement\Intents\StudentExamReport\GetStudentExamReportListData\GetStudentExamReportListDataIntent;

// Exam Management API Routes
Route::group(['middleware' => AuthGuard::class], function () {

    // Exam Subject Management - Full CRUD
    Route::post('exam-subject/create', CreateExamSubjectIntent::class);
    Route::post('exam-subject/list', GetExamSubjectListDataIntent::class);
    Route::post('exam-subject/update', UpdateExamSubjectIntent::class);

    // Exam Subject Category Management - Full CRUD
    Route::post('exam-subject-category/create', CreateExamSubjectCategoryIntent::class);
    Route::post('exam-subject-category/list', GetExamSubjectCategoryListDataIntent::class);
    Route::post('exam-subject-category/update', UpdateExamSubjectCategoryIntent::class);

    // Exam Subject Component Management - Full CRUD
    Route::post('exam-subject-component/create', CreateExamSubjectComponentIntent::class);
    Route::post('exam-subject-component/list', GetExamSubjectComponentListDataIntent::class);
    Route::post('exam-subject-component/update', UpdateExamSubjectComponentIntent::class);

    // Exam Subject Component Type Management - Full CRUD
    Route::post('exam-subject-component-type/create', CreateExamSubjectComponentTypeIntent::class);
    Route::post('exam-subject-component-type/list', GetExamSubjectComponentTypeListDataIntent::class);
    Route::post('exam-subject-component-type/update', UpdateExamSubjectComponentTypeIntent::class);

    // Exam Subject Group Management - Full CRUD
    Route::post('exam-subject-group/create', CreateExamSubjectGroupIntent::class);
    Route::post('exam-subject-group/list', GetExamSubjectGroupListDataIntent::class);
    Route::post('exam-subject-group/update', UpdateExamSubjectGroupIntent::class);

    // Exam Private Candidate Management - Full CRUD
    Route::post('exam-private-candidate/create', CreateExamPrivateCandidateIntent::class);
    Route::post('exam-private-candidate/list', GetExamPrivateCandidateListDataIntent::class);
    Route::post('exam-private-candidate/update', UpdateExamPrivateCandidateIntent::class);

    // Exam Service Charge Management - Full CRUD
    Route::post('exam-service-charge/create', CreateExamServiceChargeIntent::class);
    Route::post('exam-service-charge/list', GetExamServiceChargeListDataIntent::class);
    Route::post('exam-service-charge/update', UpdateExamServiceChargeIntent::class);

    // Exam Quiz Management
    Route::post('exam-quiz/create', CreateExamQuizIntent::class);
    Route::post('exam-quiz/list', GetExamQuizListDataIntent::class);
    Route::post('exam-quiz/generate-report', GenerateExamReportIntent::class);

    // Exam Quiz Item Management
    Route::post('exam-quiz-item/list', GetExamQuizItemListDataIntent::class);

    // Student Exam Mark Management
    Route::post('student-exam-mark/list', GetStudentExamMarkListDataIntent::class);
    Route::post('student-exam-mark/update', UpdateStudentExamMarkIntent::class);
    Route::post('student-exam-mark/removable-subject-data', RemovableSubjectStudentDataIntent::class);

    // Student Exam Report Management
    Route::post('student-exam-report/list', GetStudentExamReportListDataIntent::class);
    Route::post('student-exam-report/generate', GenerateExamReportGenerateExamReportIntent::class);
    Route::post('student-exam-report/get-by-scheduling-examination-id', GetStudentExamReportBySchedulingExaminationIdIntent::class);

    // Scheduling Examination Management
    Route::post('scheduling-examination/create', CreateSchedulingExaminationIntent::class);
    Route::post('scheduling-examination/list', GetSchedulingExaminationListDataIntent::class);
    Route::post('scheduling-examination/simple-list', GetSchedulingExaminationSimpleListDataIntent::class);
    Route::post('scheduling-examination/update', UpdateSchedulingExaminationIntent::class);
    Route::post('scheduling-examination/approve', ApproveSchedulingExaminationIntent::class);

    // Exam Mark Subject Management
    Route::post('exam-mark-subject/list', GetExamMarkSubjectListDataIntent::class);
    Route::post('exam-mark-subject/complete-educator-enter-mark', CompleteEducatorEnterMarkIntent::class);

    // Scheduling Examination Grade Management
    Route::post('scheduling-examination-grade/list', GetSchedulingExaminationGradeListDataIntent::class);

    // Student Exam Data - New Endpoint
    Route::post('student-exam-data/get-student-exam-data', GetStudentExamDataIntent::class);

});
