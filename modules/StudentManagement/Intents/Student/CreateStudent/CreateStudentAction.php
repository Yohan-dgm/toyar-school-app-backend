<?php

namespace Modules\StudentManagement\Intents\Student\CreateStudent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice\CreateAdmissionFeeInvoiceAction;
use Modules\AccountManagement\Intents\RefundableDeposit\CreateRefundableDeposit\CreateRefundableDepositAction;
use Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice\CreateSportFeeInvoiceAction;
use Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice\CreateTermFeeInvoiceAction;
use Modules\AccountManagement\Models\SchoolFee;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentAttachment;

class CreateStudentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentUserDTO = CreateStudentUserDTO::validate($payloadArray);

        // Data Prep
        $createStudentUserDTO['approved_admission_fee'] = ! array_key_exists('approved_admission_fee', $createStudentUserDTO) || is_null($createStudentUserDTO['approved_admission_fee']) || $createStudentUserDTO['approved_admission_fee'] == 'null' ? 0 : $createStudentUserDTO['approved_admission_fee'];

        $createStudentUserDTO['applicable_refundable_deposit'] = ! array_key_exists('applicable_refundable_deposit', $createStudentUserDTO) || is_null($createStudentUserDTO['applicable_refundable_deposit']) || $createStudentUserDTO['applicable_refundable_deposit'] == 'null' ? 0 : $createStudentUserDTO['applicable_refundable_deposit'];

        $createStudentUserDTO['applicable_term_payment'] = ! array_key_exists('applicable_term_payment', $createStudentUserDTO) || is_null($createStudentUserDTO['applicable_term_payment']) || $createStudentUserDTO['applicable_term_payment'] == 'null' ? 0 : $createStudentUserDTO['applicable_term_payment'];

        // System Data Prep
        $admissionNumberDigits = Student::where(function (Builder $admission_query) {})->max('admission_number_digits');

        $admission_number_digits = (int) $admissionNumberDigits + 1;
        $admission_number_current_year = strval(date('m') > 8 ? date('y') : (date('y') - 1));
        $admission_number_prefix = 'NY';
        $admission_number = $admission_number_prefix.$admission_number_current_year.'/'.$admission_number_digits;

        if ($createStudentUserDTO['gender'] == 'Male') {
            $full_name_with_title = 'Master. '.$createStudentUserDTO['full_name'];
        } elseif ($createStudentUserDTO['gender'] == 'Female') {
            $full_name_with_title = 'Miss. '.$createStudentUserDTO['full_name'];
        }
        $system_data = [
            'admission_number_digits' => $admission_number_digits,
            'admission_number_current_year' => $admission_number_current_year,
            'admission_number_prefix' => $admission_number_prefix,
            'admission_number' => $admission_number,
            'created_by' => $actionData['user_id'],
            'full_name_with_title' => $full_name_with_title,
            'joined_date' => date('Y-m-d'),
            'is_sport_list' => false,
            'grade_level_class_id' => $createStudentUserDTO['grade_level_id'],
            'is_school_leaver' => false,
        ];

        // System Data Validation
        $createStudentSystemDTO = CreateStudentSystemDTO::validate($system_data);
        // Final Data Validation
        $createStudentDTO = CreateStudentDTO::validate(array_merge($createStudentUserDTO, $createStudentSystemDTO));

        // if (array_key_exists('school_house_id', $createStudentDTO) && $createStudentDTO['school_house_id'] == "null") {
        //     unset($createStudentDTO["school_house_id"]);
        // }
        // Save In Database
        $student = Student::create($createStudentDTO);

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

        //create Admission Invoice
        $admissionData['student_id'] = $student->id;
        $admissionData['date'] = date('Y-m-d');
        $admissionData['amount'] = $createStudentUserDTO['approved_admission_fee'];
        $schoolFee = SchoolFee::where('school_fee_type', 'Admission Fee')->where('is_active', true)->first();

        $admissionData['discount_total'] = ($schoolFee == null ? 0 : $schoolFee->amount) - $createStudentUserDTO['approved_admission_fee'];
        $admissionFeeInvoiceActionData = ['created_by' => $actionData['user_id'], 'username' => $actionData['username']];
        CreateAdmissionFeeInvoiceAction::run($admissionData, $admissionFeeInvoiceActionData);

        //create Refundable Deposit Invoice
        $refundableData['student_id'] = $student->id;
        $refundableData['date'] = date('Y-m-d');
        $refundableData['amount'] = $createStudentUserDTO['applicable_refundable_deposit'];
        $schoolFee = SchoolFee::where('school_fee_type', 'Refundable Deposit')
            ->where('is_active', true)->first();
        $refundableData['discount_total'] = ($schoolFee == null ? 0 : $schoolFee->amount) - $createStudentUserDTO['applicable_refundable_deposit'];
        $refundableFeeInvoiceActionData = ['created_by' => $actionData['user_id'], 'username' => $actionData['username']];
        CreateRefundableDepositAction::run($refundableData, $refundableFeeInvoiceActionData);

        //create Term Fee Invoice
        $termFeeData['student_id'] = $student->id;
        $termFeeData['date'] = date('Y-m-d');
        $termFeeData['amount'] = $createStudentUserDTO['applicable_term_payment'];
        $termFeeData['grade_level_id'] = $createStudentUserDTO['grade_level_id'];
        $schoolFee = SchoolFee::where('school_fee_type', 'Term Fee')
            ->where('grade_level_id', $createStudentUserDTO['grade_level_id'])
            ->where('is_active', true)->first();

        // var_dump($schoolFee);
        $schoolFee == null ? $schoolFeeAmount = 0 : $schoolFeeAmount = $schoolFee->amount;
        $termFeeData['discount_total'] = $schoolFeeAmount - $createStudentUserDTO['applicable_term_payment'];
        $termFeeFeeInvoiceActionData = ['created_by' => $actionData['user_id'], 'username' => $actionData['username']];
        CreateTermFeeInvoiceAction::run($termFeeData, $termFeeFeeInvoiceActionData);

        //create Sport Fee Invoice
        if ($createStudentUserDTO['grade_level_id'] >= 6 && $createStudentUserDTO['grade_level_id'] <= 9) {
            $sportFeeData['student_id'] = $student->id;
            $sportFeeData['date'] = date('Y-m-d');
            $schoolFee = SchoolFee::where('school_fee_type', 'Sport Fee')
                ->where('is_active', true)->first();
            $sportFeeData['amount'] = ($schoolFee == null ? 0 : $schoolFee->amount);
            $sportFeeData['discount_total'] = 0;
            $sportFeeData['items_total'] = $schoolFee->amount * 4;
            $sportFeeData['subtotal_before_discount'] = $schoolFee->amount * 4;
            $sportFeeData['subtotal_after_discount'] = $schoolFee->amount * 4;
            $sportFeeData['bill_total'] = $schoolFee->amount * 4;

            $sportFeeData['sport_fee_invoice_item_list'] = [
                [
                    'school_fee_id' => $schoolFee->id,
                    'description' => 'Sports Fee',
                    'unit_price' => $schoolFee->amount,
                    'qty' => 4,
                    'item_total' => $schoolFee->amount * 4,
                ],
            ];
            $sportFeeFeeInvoiceActionData = ['created_by' => $actionData['user_id'], 'username' => $actionData['username']];
            CreateSportFeeInvoiceAction::run($sportFeeData, $sportFeeFeeInvoiceActionData);
        }

        // create student activity log
        $logData['description'] = '[STATUS: Successfully Created Student, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', STUDENT: .'.$student->admission_number;
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
