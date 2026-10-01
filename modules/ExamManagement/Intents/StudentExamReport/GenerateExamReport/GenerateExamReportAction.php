<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GenerateExamReport;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ExamManagement\Models\SchedulingExamination;
use Modules\ExamManagement\Models\SchedulingExaminationGrade;
use Modules\ExamManagement\Models\SchedulingExaminationGradeSubject;
use Modules\ExamManagement\Models\StudentExamMark;
use Modules\ExamManagement\Models\StudentExamReport;
use Modules\ExamManagement\Models\StudentExamReportItem;
use Modules\ExamManagement\Models\StudentSubjectMark;
use Modules\LogManagement\Intents\ExamLog\CreateExamLog\CreateExamLogAction;
use Modules\ProgramManagement\Models\Subject;
use Modules\StudentManagement\Models\Student;

class GenerateExamReportAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $generateExamReportUserDTO = GenerateExamReportUserDTO::validate($payloadArray);
        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // Get Data
        $student_id_list = [];
        // $schedulingExaminationGrade = SchedulingExaminationGrade::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])->get();
        $schedulingExaminationGrade = SchedulingExaminationGrade::where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id'])->get();
        if (! $schedulingExaminationGrade->isEmpty()) {
            foreach ($schedulingExaminationGrade as $schedulingExaminationGradeData) {
                $schedulingExaminationGradeSubject = SchedulingExaminationGradeSubject::where('scheduling_examination_grade_id', $schedulingExaminationGradeData['id'])->get();
                if (! $schedulingExaminationGradeSubject->isEmpty()) {
                    foreach ($schedulingExaminationGradeSubject as $schedulingExaminationGradeSubjectData) {
                        $studentExamMark = StudentExamMark::where('scheduling_examination_grade_subject_id', $schedulingExaminationGradeSubjectData->id)->get();
                        if (! $studentExamMark->isEmpty()) {
                            foreach ($studentExamMark as $mark) {
                                $student_id_list[] = $mark->student_id;
                            }
                        }
                    }
                }
            }
        }
        // Save In Database
        $student_id_list = array_unique($student_id_list);
        // $examQuiz = StudentExamReport::where('id', $generateExamReportUserDTO['id'])->first();
        if (! empty($student_id_list)) {
            foreach ($student_id_list as $student_id) {
                $examReportData = [];
                $examReportData['student_id'] = $student_id;
                $examReportData['scheduling_examination_id'] = $generateExamReportUserDTO['scheduling_examinations_id'];
                $examReportData['created_by'] = $actionData['updated_by'];
                $examReportData['grade_level_class_id'] = Student::where('id', $student_id)->value('grade_level_class_id');
                $examReportData['grade_level_name'] = SchedulingExaminationGrade::where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id'])->with(['program' => function ($query) {
                    $query->with(['grade_level' => function ($query) {
                        return $query->select('id', 'name');
                    }]);
                    $query->select('id', 'grade_level_id');
                }])->select('id', 'program_id')->get()->first()->program->grade_level->name;

                //serial No. start
                $examReportData['serial_number_prefix'] = 'NY/SER';
                $maxDigits = StudentExamReport::where(function (Builder $receipt_query) {
                    $serial_number_financial_year = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
                    $receipt_query->where('serial_number_financial_year', '=', $serial_number_financial_year);
                })->max('serial_number_digits');

                if ($maxDigits > 0) {
                    $serial_number_digits = (int) $maxDigits + 1;
                } else {
                    $serial_number_digits = 1;
                }
                $examReportData['serial_number_digits'] = $serial_number_digits;
                $examReportData['serial_number_current_year'] = date('y');
                $examReportData['serial_number_financial_year'] = (date('m') > 3) ? date('y').'-'.(date('y') + 1) : (date('y') - 1).'-'.date('y');
                $examReportData['serial_number_suffix'] = '';
                if ($examReportData['serial_number_suffix'] == '') {
                    $examReportData['serial_number'] = $examReportData['serial_number_prefix'].'/'.$examReportData['serial_number_current_year'].'/'.$examReportData['serial_number_financial_year'].'/'.$examReportData['serial_number_digits'];
                } else {
                    $examReportData['serial_number'] = $examReportData['serial_number_prefix'].'/'.$examReportData['serial_number_current_year'].'/'.$examReportData['serial_number_financial_year'].'/'.$examReportData['serial_number_digits'].'/'.$examReportData['serial_number_suffix'];
                }
                //serial No. end

                $oldStudentExamReport = StudentExamReport::where('student_id', $student_id)->where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])->first();
                if (! empty($oldStudentExamReport)) {
                    unset($examReportData['serial_number_prefix']);
                    unset($examReportData['serial_number_digits']);
                    unset($examReportData['serial_number_current_year']);
                    unset($examReportData['serial_number_financial_year']);
                    unset($examReportData['serial_number_suffix']);
                    unset($examReportData['serial_number']);
                    StudentExamReport::where('id', $oldStudentExamReport->id)->update($examReportData);
                    $studentExamReport = $oldStudentExamReport;
                } else {
                    $studentExamReport = StudentExamReport::create($examReportData);
                }

                $studentExamMark = StudentExamMark::where(function (Builder $student_exam_mark_query) use ($student_id, $generateExamReportUserDTO) {
                    $student_exam_mark_query->whereHas('scheduling_examination_grade_subject_item', function (Builder $scheduling_examination_grade_subject_item_query) use ($generateExamReportUserDTO) {
                        $scheduling_examination_grade_subject_item_query->whereHas('scheduling_examination_grade', function (Builder $scheduling_examination_grade_query) use ($generateExamReportUserDTO) {
                            $scheduling_examination_grade_query->where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])->where('is_active', true);
                        });
                    });
                    $student_exam_mark_query->where('student_id', $student_id);
                })
                    ->with('scheduling_examination_grade_subject_item')
                    ->get();

                $student_total_mark = 0;
                $overall_mark = 0;
                $subject_count = 0;
                if (! $studentExamMark->isEmpty()) {
                    foreach ($studentExamMark as $ExamMark) {
                        $studentExamMarkDate = [];
                        $studentExamMarkDate['student_exam_report_id'] = $studentExamReport->id;
                        $studentExamMarkDate['scheduling_examination_grade_subject_id'] = $ExamMark->scheduling_examination_grade_subject_id;
                        $studentExamMarkDate['student_exam_mark_id'] = $ExamMark->id;
                        $studentExamMarkDate['subject_mark'] = $ExamMark->subject_total_mark;
                        $studentExamMarkDate['subject_overall_mark_percentage'] = $ExamMark->subject_overall_mark_percentage;
                        $studentExamMarkDate['present_type'] = $ExamMark->present_type;
                        $studentExamMarkDate['grading'] = $ExamMark->grading;
                        $studentExamMarkDate['subject_id'] = $ExamMark->scheduling_examination_grade_subject_item->subject_id;
                        $studentExamMarkDate['subject_name'] = Subject::where('id', $ExamMark->scheduling_examination_grade_subject_item->subject_id)->value('name');
                        $studentExamMarkDate['updated_by'] = $actionData['updated_by'];

                        $studentSubjectMark = StudentSubjectMark::where('student_exam_mark_id', $ExamMark->id)->get();
                        if (! empty($studentSubjectMark)) {
                            foreach ($studentSubjectMark as $studentSubjectMarkData) {
                                $overall_mark += floatval($studentSubjectMarkData['overall_mark']);
                            }
                        }
                        // $student_total_mark += floatval($ExamMark->subject_total_mark);
                        $student_total_mark += floatval($ExamMark->subject_overall_mark_percentage);
                        $subject_count++;
                        $oldStudentExamReportItem = StudentExamReportItem::where('student_exam_report_id', $studentExamReport->id)
                            ->where('student_exam_mark_id', $ExamMark->id)->first();
                        if (! empty($oldStudentExamReportItem)) {
                            StudentExamReportItem::where('id', $oldStudentExamReportItem->id)->update($studentExamMarkDate);
                        } else {
                            StudentExamReportItem::create($studentExamMarkDate);
                        }
                    }
                }

                if ($student_total_mark == 0 || $overall_mark == 0) {
                    $examReportData['student_average'] = 0;
                } else {
                    // $examReportData['student_average'] = ($student_total_mark / $overall_mark) * 100;
                    $examReportData['student_average'] = $student_total_mark / $subject_count;
                }

                $examReportData['aggregate_of_mark'] = $student_total_mark;
                StudentExamReport::where('id', $studentExamReport->id)->update($examReportData);
            }
            // $updateSchedulingExamination['is_generate_student_exam_report'] = true;
            // SchedulingExamination::where('id', $generateExamReportUserDTO['scheduling_examinations_id'])->update($updateSchedulingExamination);
            $updateSchedulingExaminationGrade['is_generate_student_exam_report'] = true;
            SchedulingExaminationGrade::where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id'])->update($updateSchedulingExaminationGrade);

            $schedulingExaminationData = SchedulingExaminationGrade::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->where('is_generate_student_exam_report', false)->first();

            if ($schedulingExaminationData == null) {
                $updateSchedulingExamination['is_generate_student_exam_report'] = true;
                SchedulingExamination::where('id', $generateExamReportUserDTO['scheduling_examinations_id'])->update($updateSchedulingExamination);
            }

            $schedulingExaminationGradeData = SchedulingExaminationGrade::where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id'])
                ->where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->with('program') // just the relation name
                ->get()->first();
            // Now access grade_level_id via the related program
            $gradeLevelId = $schedulingExaminationGradeData->program['grade_level_id'];

            $classStudentTotalMarks = StudentExamReport::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->whereHas('grade_level_class', function ($grade_level_class_query) use ($gradeLevelId) {
                    $grade_level_class_query->where('grade_level_id', $gradeLevelId);
                })->sum('student_average');

            $totalStudentCount = StudentExamReport::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->whereHas('grade_level_class', function ($grade_level_class_query) use ($gradeLevelId) {
                    $grade_level_class_query->where('grade_level_id', $gradeLevelId);
                })->count('id');

            $classTotalMark = StudentExamReport::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->whereHas('scheduling_examination', function ($q) use ($generateExamReportUserDTO) {
                    $q->whereHas('scheduling_examinations_grade_list', function ($q2) use ($generateExamReportUserDTO) {
                        $q2->where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id']);
                    });
                })
                ->with([
                    'scheduling_examination.scheduling_examinations_grade_list.scheduling_examinations_grade_subject_list.scheduling_examinations_subject_paper_list',
                ])
                ->get()
                ->flatMap(function ($report) {
                    return $report->scheduling_examination->scheduling_examinations_grade_list
                        ->flatMap(function ($gradeList) {
                            return $gradeList->scheduling_examinations_grade_subject_list
                                ->flatMap(function ($subjectList) {
                                    return $subjectList->scheduling_examinations_subject_paper_list;
                                });
                        });
                })
                ->sum('overall_mark');

            // $classAvarage = ($classStudentTotalMarks / $classTotalMark) * 100;
            $classAvarage = $classStudentTotalMarks / $totalStudentCount;

            // $studentExamReportDataList = StudentExamReport::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
            //     ->whereHas('scheduling_examination', function ($scheduling_examination_query) use ($generateExamReportUserDTO) {
            //         $scheduling_examination_query->whereHas('scheduling_examinations_grade_list', function ($scheduling_examinations_grade_list_query) use ($generateExamReportUserDTO) {
            //             $scheduling_examinations_grade_list_query->where('id', $generateExamReportUserDTO['scheduling_examinations_grade_id']);
            //             // var_dump($generateExamReportUserDTO['scheduling_examinations_grade_id']);
            //         });
            //     })->select('id', 'aggregate_of_mark')->orderBy('aggregate_of_mark', 'desc')->get();

            $studentExamReportDataList = StudentExamReport::where('scheduling_examination_id', $generateExamReportUserDTO['scheduling_examinations_id'])
                ->whereHas('grade_level_class', function ($grade_level_class_query) use ($gradeLevelId) {
                    $grade_level_class_query->where('grade_level_id', $gradeLevelId);
                })->select('id', 'aggregate_of_mark')->orderBy('aggregate_of_mark', 'desc')->get();

            if ($studentExamReportDataList->count() > 0) {
                for ($i = 0; $i < $studentExamReportDataList->count(); $i++) {
                    $updateData = [
                        'class_average' => $classAvarage,
                        'class_rank' => $i + 1,
                    ];

                    StudentExamReport::where('id', $studentExamReportDataList[$i]['id'])->update($updateData);
                }
            }
        }

        // create exam log
        $logData['description'] = '[STATUS: Generated Student Exam Report, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        $logData['type'] = 'Student Exam Report';
        CreateExamLogAction::run($logData, ['created_by' => $actionData['updated_by']]);

        return $studentExamReport;
    }
}
