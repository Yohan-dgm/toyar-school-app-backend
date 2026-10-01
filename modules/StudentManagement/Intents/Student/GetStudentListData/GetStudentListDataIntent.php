<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\StudentManagement\Models\SchoolHouse;
use Modules\StudentManagement\Models\Student;

class GetStudentListDataIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // Authorization

            // Student Data Validation
            $getStudentListDataUserDTO = GetStudentListDataUserDTO::validate($request->all());

            // Before Intent

            // Business Rules Validation

            // Action 1
            $actionData = [];
            $actionData['user_id'] = $request->user()->id;
            $actionData['username'] = $request->user()->username;
            $studentListData = GetStudentListDataAction::run($getStudentListDataUserDTO, $actionData);

            $data['student_count'] = DB::table('student')->where('has_dropped_out', false)->where('is_school_leaver', false)->count();
            $data['dropped_out_student_count'] = DB::table('student')->where('has_dropped_out', true)->count();
            $data['school_leaver_student_count'] = DB::table('student')->where('is_school_leaver', true)->count();
            $data['incomplete_student_count'] = DB::table('student')
                ->whereNull('father_full_name')
                ->whereNull('mother_full_name')
                ->whereNull('guardian_full_name')
                ->count();
            $data['incomplete_address_student_count'] = DB::table('student')
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', true)
                ->whereNull('student_address')
                ->orWhere('student_address', '')
                ->orWhere('student_address', '<p></p>')
                ->count();
            $data['incomplete_photo_student_count'] = Student::where('has_dropped_out', false)->where('is_school_leaver', false)->doesntHave('student_attachment_list')
                ->count();
            $data['grade_level_student_count'] = GradeLevel::select('id', 'name')->withCount(['student_list' => function (Builder $student_list_query) {
                return $student_list_query->where('has_dropped_out', false)->where('is_school_leaver', false);
            }])->orderBy('id', 'asc')->get();

            $data['school_house_student_count'] = SchoolHouse::select('id', 'name')->withCount(['student_list' => function (Builder $student_list_query) {
                $student_list_query->whereNotNull('school_house_id')->where('has_dropped_out', false)->where('is_school_leaver', false);
            }])->orderBy('id', 'asc')->get();

            // $data['grade_level_teacher_role_list'] = DB::table('educator_role')
            //     ->select('educator_role.educator_id as educator_id', 'educator_role.user_id', 'educator_role.role_type_id', 'employee.full_name', 'educator_role.role_type_id as grade_level_id', 'educator_attendance.attendance_type_id as attendance_type_id')
            //     ->where('educator_role.is_active', true)
            //     ->join('educator', 'educator_role.educator_id', '=', 'educator.id')
            //     ->join('employee', 'educator.employee_id', '=', 'employee.id')
            //     ->join('educator_attendance', 'educator_attendance.educator_id', '=', 'employee.id')
            //     ->get();

            // $data['grade_level_teacher_role_list'] = DB::table('educator_role')
            //        ->select('educator_role.educator_id as educator_id', 'educator_role.user_id', 'educator_role.role_type_id','employee.full_name', 'educator_role.role_type_id as grade_level_id' )
            //       ->where('educator_role.is_active', true)
            //        ->join('educator', 'educator_role.educator_id', '=', 'educator.id')
            //        ->join('employee', 'educator.employee_id', '=', 'employee.id')
            //        ->get();

            // $data['grade_level_class_moniter'] = DB::table('student_role')
            //     ->select(
            //         'student.grade_level_id',
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->whereIn('student_role.role_type_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30])

            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',

            //         'student.grade_level_id',
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_Senior_prefect_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 43)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_junior_prefect_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 45)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_game_captain'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 47)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_deputy_game_captain'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 48)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_head_prefect'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->whereIn('student_role.role_type_id', [31, 32])
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['school_deputy_head_prefect'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->whereIn('student_role.role_type_id', [33, 34])

            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['vulcan_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 35)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['tellus_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=',  36)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['eurus_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 37)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['calypso_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 38)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // //Deputy house Captains

            // $data['deputy_vulcan_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->whereIn('student_role.role_type_id', [39, 40, 41, 42])

            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['deputy_tellus_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=',  40)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['deputy_eurus_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 41)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['deputy_calypso_house_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->where('student_role.role_type_id', '=', 42)
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // $data['house_deputy_captain_role_list'] = DB::table('student_role')
            //     ->select(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id',
            //         DB::raw('MIN(student_attachment.id) as student_attachment_id'), // or MAX
            //         DB::raw('MAX(student_attendance.date) as attendance_date'), // get latest date
            //         DB::raw('MAX(student_attendance.attendance_type_id) as attendance_type_id') // match latest date logic
            //     )
            //     ->where('student_role.is_active', '=', 1)
            //     ->whereIn('student_role.role_type_id', [39, 40, 41, 42])
            //     ->join('student', 'student_role.student_id', '=', 'student.id')
            //     ->join('student_attachment', 'student.id', '=', 'student_attachment.student_id')
            //     ->leftJoin('student_role_type', 'student_role.role_type_id', '=', 'student_role_type.id')
            //     ->leftJoin('student_attendance', 'student.id', '=', 'student_attendance.student_id')
            //     ->groupBy(
            //         'student_role.student_id',
            //         'student_role.role_type_id',
            //         'student.full_name',
            //         'student.student_calling_name',
            //         'student.school_house_id'
            //     )
            //     ->orderBy('student.full_name', 'asc')
            //     ->get();

            // After Intent

            // Return Response
            return array_merge($studentListData->toArray(), $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            // Response Data Validation
            $GetStudentListDataResDTO = GetStudentListDataResDTO::validate($result);

            return response()->json(
                [
                    'status' => 'successful',
                    'message' => '',
                    'data' => $GetStudentListDataResDTO,
                    'metadata' => null,
                ],
                200
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
