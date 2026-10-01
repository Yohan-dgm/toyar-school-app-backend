<?php

namespace Modules\StudentManagement\Intents\StudentInsights\GetPublicStudentInsightsListData;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\DB;
use Modules\StudentManagement\Models\Student;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\ExamManagement\Models\StudentExamReport;
use Modules\AttendanceManagement\Models\StudentAttendance;
use Modules\SystemEntityManagement\Models\Term;
use Modules\StudentManagement\Intents\StudentInsights\GetStudentInsightsListData\GetStudentInsightsListDataUserDTO;

class GetPublicStudentInsightsListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // StudentInsights Data Validation
            $getStudentInsightsListDataUserDTO = GetStudentInsightsListDataUserDTO::validate($request->all());

            $studentData = Student::where("id", $getStudentInsightsListDataUserDTO['student_id'])
                ->with([
                'grade_level_class' => function (Builder $grade_level_class_query) {
                // 
                $grade_level_class_query->select("id", "name");
            }
            ])
                ->with([
                'student_attachment_list' => function (Builder $student_attachment_list_query) {
                //
                $student_attachment_list_query->select(
                    "id",
                    "student_id",
                    "file_name",
                    "original_file_name",
                    "mime_type")->orderBy('id', 'desc');
            }
            ])
                ->select(
                'id',
                'full_name_with_title',
                'admission_number',
                'full_name',
                'grade_level_class_id')->get();

            $studentAchievements = DB::table("student_achievement")->where("student_id", $getStudentInsightsListDataUserDTO['student_id'])->get();

            $studentMarkSubjectList = StudentExamReport::where("student_id", $getStudentInsightsListDataUserDTO['student_id'])
                ->whereHas('scheduling_examination', function (Builder $query) {
                    $query->where('exam_type', 'Term Test');
                })
                ->with([
                'student_exam_report_item_list' => function (Builder $student_exam_report_item_list_query) {
                //
                $student_exam_report_item_list_query->select(
                    "id",
                    'student_exam_report_id',
                    "subject_name",
                    "subject_overall_mark_percentage",
                    "subject_position");
            }])
                ->with([
                'scheduling_examination' => function (Builder $scheduling_examination_query) {
                //
                $scheduling_examination_query->with([
                        'term' => function (Builder $term_query) {
                    //
                    $term_query->select(
                            "id",
                            'name',
                            'school_year');
                }
                    ]);
                $scheduling_examination_query->select(
                    "id",
                    'exam_title',
                    "term_id");
            }])
                ->select(
                'id',
                'scheduling_examination_id',
                'student_average',
                'aggregate_of_mark',
                'class_rank',
                'class_average')->orderBy('id', 'asc')->get();

            // 1. Determine newest school_year by highest term.id
            $newestSchoolYear = null;
            $highestTermId = 0;
            $studentMarkSubjectList->each(function ($report) use (&$newestSchoolYear, &$highestTermId) {
                $term = $report->scheduling_examination->term ?? null;
                if ($term && $term->id > $highestTermId) {
                    $highestTermId = $term->id;
                    $newestSchoolYear = $term->school_year;
                }
            });

            // Filter to only records that belong to the newest school_year
            if ($newestSchoolYear) {
                $studentMarkSubjectList = $studentMarkSubjectList->filter(function ($report) use ($newestSchoolYear) {
                    $termSchoolYear = $report->scheduling_examination->term->school_year ?? null;
                    return $termSchoolYear === $newestSchoolYear;
                })->values();
            }

            // 2. Get Unique Subjects, Terms and Exam IDs
            $subjectList = [];
            $termList = [];
            $examIds = [];
            
            $studentMarkSubjectList->each(function ($report) use (&$subjectList, &$termList, &$examIds) {
                $term = $report->scheduling_examination->term ?? null;
                $schoolYear = $term->school_year ?? '';
                $termName = $term->name ?? '';
                
                // Build a clean label
                $label = $termName;
                if ($schoolYear && !str_contains($termName, $schoolYear)) {
                    $label = $schoolYear . ($termName ? ' - ' . $termName : '');
                }
                
                // Fallback to Exam Title if term info is missing
                if (!$label || trim($label) == '-') {
                    $label = $report->scheduling_examination->exam_title ?? 'Exam ' . $report->scheduling_examination_id;
                }
                
                $termList[] = trim($label);
                $examIds[] = $report->scheduling_examination_id;
                
                $report->student_exam_report_item_list->each(function ($reportItem) use (&$subjectList) {
                    $subjectList[] = $reportItem->subject_name;
                });
            });
            
            $subjectList = array_values(array_unique($subjectList));
            sort($subjectList); // Sort subjects alphabetically
            $termList = array_values(array_unique($termList)); // Chronological order
            $examIds = array_unique($examIds);

            // 3. Fetch Class Averages per Subject for these Exams
            $classSubjectAverages = DB::table('student_exam_report_item')
                ->join('student_exam_report', 'student_exam_report_item.student_exam_report_id', '=', 'student_exam_report.id')
                ->whereIn('student_exam_report.scheduling_examination_id', $examIds)
                ->select(
                    'student_exam_report.scheduling_examination_id',
                    'student_exam_report_item.subject_name',
                    DB::raw('AVG(student_exam_report_item.subject_overall_mark_percentage) as average')
                )
                ->groupBy('student_exam_report.scheduling_examination_id', 'student_exam_report_item.subject_name')
                ->get()
                ->groupBy('scheduling_examination_id');

            // 4. Map Marks to a Matrix [Subject][TermLabel]
            $matrix = [];
            $subjectRanks = [];
            
            $studentMarkSubjectList->each(function ($report) use (&$matrix, &$subjectRanks, $classSubjectAverages) {
                // Generate the same label as above
                $term = $report->scheduling_examination->term ?? null;
                $schoolYear = $term->school_year ?? '';
                $termName = $term->name ?? '';
                $label = trim($schoolYear && !str_contains($termName, $schoolYear) ? ($schoolYear . ' - ' . $termName) : $termName);
                if (!$label || $label == '-') $label = $report->scheduling_examination->exam_title ?? 'Exam ' . $report->scheduling_examination_id;
                
                $examId = $report->scheduling_examination_id;
                $averagesForExam = $classSubjectAverages->get($examId);

                $report->student_exam_report_item_list->each(function ($reportItem) use (&$matrix, &$subjectRanks, $label, $averagesForExam, $report) {
                    $subjectName = $reportItem->subject_name;
                    $mark = $reportItem->subject_overall_mark_percentage;
                    
                    $subjectAvg = 0;
                    if ($averagesForExam) {
                        $avgItem = $averagesForExam->where('subject_name', $subjectName)->first();
                        $subjectAvg = $avgItem ? round($avgItem->average, 2) : 0;
                    }

                    $matrix[$subjectName][$label] = [
                        'mark' => $mark,
                        'class_avg' => $report->class_average,
                        'student_avg' => $report->student_average,
                        'subject_avg' => $subjectAvg
                    ];
                    
                    $subjectRanks[$subjectName] = $reportItem->subject_position;
                });
            });

            // 5. Build Subject Wise Performance with Term-Mark Objects
            $subjectWisePerformance = [];
            foreach ($subjectList as $subject) {
                $marksArray = [];
                $availableMarks = []; // For trend analysis
                
                foreach ($termList as $term) {
                    $dataFound = $matrix[$subject][$term] ?? null;
                    $marksArray[] = [
                        'term' => $term,
                        'mark' => $dataFound['mark'] ?? null,
                        'class_avg' => $dataFound['class_avg'] ?? null,
                        'student_avg' => $dataFound['student_avg'] ?? null,
                        'subject_avg' => $dataFound['subject_avg'] ?? null,
                    ];
                    if ($dataFound !== null && $dataFound['mark'] !== null) {
                        $availableMarks[] = $dataFound['mark'];
                    }
                }

                // Trend Calculation (compared to previous available term)
                // Note: availableMarks is now in Ascending order [Oldest ... Latest]
                $status = 'Stable';
                $count = count($availableMarks);
                if ($count >= 2) {
                    $latest = $availableMarks[$count - 1];
                    $previous = $availableMarks[$count - 2];
                    if ((float)$latest > (float)$previous) $status = 'Up';
                    elseif ((float)$latest < (float)$previous) $status = 'Down';
                }

                $subjectWisePerformance[] = [
                    'name' => $subject,
                    'marks' => $marksArray, // Aligned with term_list as objects
                    'rank' => $subjectRanks[$subject] ?? null,
                    'status' => $status
                ];
            }

            // 6. Attendance Summary by Term
            $attendanceSummary = [];
            $allTerms = Term::orderBy('start_date', 'asc')->get();
            $allAttendance = StudentAttendance::where('student_id', $getStudentInsightsListDataUserDTO['student_id'])->get();

            foreach ($allTerms as $term) {
                if (!$term->start_date || !$term->end_date) continue;

                $counts = $allAttendance->filter(function ($item) use ($term) {
                    return $item->date >= $term->start_date && $item->date <= $term->end_date;
                });

                $present = $counts->where('attendance_type_id', 1)->count();
                $absent = $counts->where('attendance_type_id', 4)->count();

                if ($present === 0 && $absent === 0) {
                    continue;
                }

                $attendanceSummary[] = [
                    'term' => $term->name,
                    'present' => $present,
                    'absent' => $absent,
                    'attendance_percentage' => ($present + $absent) > 0 ? round(($present / ($present + $absent)) * 100, 1) : 0,
                ];
            }

            $data = [
                'student_data' => $studentData->first(),
                'student_achievements' => $studentAchievements,
                'student_mark_subject_list' => $studentMarkSubjectList,
                'subject_list' => $subjectList,
                'term_list' => $termList,
                'subject_wise_performance' => $subjectWisePerformance,
                'attendance_summary' => $attendanceSummary
            ];
            // Return Response
            return $data;
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            return response()->json(
            [
                "status" => "successful",
                "message" => "",
                "data" => $result,
                "metadata" => null,
            ],
                200
            );
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }
}
