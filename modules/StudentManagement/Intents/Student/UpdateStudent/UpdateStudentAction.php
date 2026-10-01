<?php

namespace Modules\StudentManagement\Intents\Student\UpdateStudent;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentAttachment;

class UpdateStudentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateStudentUserDTO = UpdateStudentUserDTO::validate($payloadArray);

        // Data Prep
        $updateStudentUserDTO['approved_admission_fee'] = ! array_key_exists('approved_admission_fee', $updateStudentUserDTO) || is_null($updateStudentUserDTO['approved_admission_fee']) || $updateStudentUserDTO['approved_admission_fee'] == 'null' ? 0 : $updateStudentUserDTO['approved_admission_fee'];

        $updateStudentUserDTO['applicable_refundable_deposit'] = ! array_key_exists('applicable_refundable_deposit', $updateStudentUserDTO) || is_null($updateStudentUserDTO['applicable_refundable_deposit']) || $updateStudentUserDTO['applicable_refundable_deposit'] == 'null' ? 0 : $updateStudentUserDTO['applicable_refundable_deposit'];

        $updateStudentUserDTO['applicable_term_payment'] = ! array_key_exists('applicable_term_payment', $updateStudentUserDTO) || is_null($updateStudentUserDTO['applicable_term_payment']) || $updateStudentUserDTO['applicable_term_payment'] == 'null' ? 0 : $updateStudentUserDTO['applicable_term_payment'];

        // System Data Prep
        $system_data = [];
        if ($updateStudentUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Master. '.$updateStudentUserDTO['full_name'];
        } elseif ($updateStudentUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$updateStudentUserDTO['full_name'];
        }
        $system_data = [
            'updated_by' => $actionData['user_id'],
            'full_name_with_title' => $full_name_with_title,
            'grade_level_class_id' => $updateStudentUserDTO['grade_level_id'],
        ];

        // System Data Validation
        $updateStudentSystemDTO = UpdateStudentSystemDTO::validate($system_data);
        // Final Data Validation
        $updateStudentDTO = UpdateStudentDTO::validate(array_merge($updateStudentUserDTO, $updateStudentSystemDTO));

        // if (array_key_exists('school_house_id', $updateStudentDTO) && $updateStudentDTO['school_house_id'] == "null") {
        //     unset($updateStudentDTO["school_house_id"]);
        // }
        // Save In Database
        Student::where('id', $updateStudentUserDTO['id'])->update($updateStudentDTO);

        $student = Student::find($updateStudentUserDTO['id']);

        // Updade Saved Attachments
        if (is_null($actionData['student_attachment_list']) && count($student->student_attachment_list) > 0) {
            $persistedAttachmentList = $student->student_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = $persistedFileNameList;
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    StudentAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/student-management/student/$student->admission_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }
        if (! is_null($actionData['student_attachment_list']) && count($actionData['student_attachment_list']) > 0 && count($student->student_attachment_list) > 0) {
            $persistedAttachmentList = $student->student_attachment_list;
            $persistedFileNameList = [];
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                array_push($persistedFileNameList, $persistedAttachment->file_name);
            }
            $fileNamesToBeDeleted = array_merge(array_diff($persistedFileNameList, $actionData['student_attachment_list']), array_diff($actionData['student_attachment_list'], $persistedFileNameList));
            // Remove from database
            foreach ($persistedAttachmentList as $persistedAttachmentKey => $persistedAttachment) {
                if (in_array($persistedAttachment->file_name, $fileNamesToBeDeleted)) {
                    StudentAttachment::destroy($persistedAttachment->id);
                }
            }
            // Remove from storage
            $path = "app/private/attachments/student-management/student/$student->admission_number_digits/";
            foreach ($fileNamesToBeDeleted as $fileNameKey => $fileName) {
                unlink(storage_path($path.$fileName));
            }
        }

        // Create Unsaved Attachments
        if (! is_null($actionData['student_unsaved_attachment_list']) && count($actionData['student_unsaved_attachment_list']) > 0) {
            foreach ($actionData['student_unsaved_attachment_list'] as $unsaved_attachment_key => $unsaved_attachment) {
                $path = "attachments/student-management/student/$student->admission_number_digits/";
                $data = [];
                $data['student_id'] = $student->id;
                $data['extension'] = ! is_null($unsaved_attachment->extension()) ? $unsaved_attachment->extension() : $unsaved_attachment->getClientOriginalExtension();
                $data['file_name'] = $this->getUniqueFileName($student->admission_number_digits, $path, $data['extension']);
                $data['original_file_name'] = $unsaved_attachment->getClientOriginalName();
                $data['mime_type'] = $unsaved_attachment->getClientMimeType();
                $data['created_by'] = $actionData['user_id'];
                $studentAttachment = StudentAttachment::create($data);
                $pathWithFileNameAndExtension = "attachments/student-management/student/$student->admission_number_digits/".$data['file_name'];
                Storage::disk('local')->put($pathWithFileNameAndExtension, file_get_contents($unsaved_attachment));
            }
        }

        // create student activity log
        $logData['description'] = '[Status: Successfully Updated Student, IP: '.$_SERVER['REMOTE_ADDR'].', User: '.$actionData['username'].', Student: .'.$student->admission_number
            .', User: '.$actionData['username'].'] ';
        $logData['user_name'] = $actionData['username'];
        CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);

        return $student;
    }

    public function getUniqueFileName($prefix, $path, $extension)
    {
        $count = 1;
        $file = '';
        if (is_null($extension)) {
            $extension = '';
        }
        do {
            if ($count == 1) {
                $file = $prefix.'-'.microtime(true).'.'.$extension;
                $count++;
            } else {
                $file = $prefix.'-'.microtime(true).'_'.$count.'.'.$extension;
                $count++;
            }
        } while (file_exists($path.$file));

        return $file;
    }
}
