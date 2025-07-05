<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Modules\EducatorManagement\Models\Educator;
use Illuminate\Http\Request;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice\CreateAdmissionFeeInvoiceDTO;
use Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice\CreateAdmissionFeeInvoiceSystemDTO;
use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItem\CreateAdmissionFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Intents\RefundableDeposit\CreateRefundableDeposit\CreateRefundableDepositDTO;
use Modules\AccountManagement\Intents\RefundableDeposit\CreateRefundableDeposit\CreateRefundableDepositSystemDTO;
use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemAction;
use Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem\CreateRefundableDepositItemUserDTO;
use Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice\CreateSportFeeInvoiceDTO;
use Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice\CreateSportFeeInvoiceSystemDTO;
use Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice\CreateSportFeeInvoiceUserDTO;
use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem\CreateSportFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice\CreateTermFeeInvoiceDTO;
use Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice\CreateTermFeeInvoiceSystemDTO;
use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemAction;
use Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem\CreateTermFeeInvoiceItemUserDTO;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\TermFeePayment;
use Modules\ProgramManagement\Models\GradeLevel;
use Modules\ProgramManagement\Models\Sport;
use Modules\StudentManagement\Intents\StudentSupplyNote\CreateStudentSupplyNote\CreateStudentSupplyNoteAction;
use Modules\StudentManagement\Intents\StudentSupplyNote\CreateStudentSupplyNote\CreateStudentSupplyNoteUserDTO;
use Modules\StudentManagement\Models\Student;
use Modules\SystemEntityManagement\Models\Term;

class QuickDataHackController extends Controller
{

    function index() {}

    function assignSchoolHouseToStudent(Request $request)
    {
        // 1. first remove house from all students
        Student::where("id", ">", 0)->update(["school_house_id" => null]);

        // 2. assign houses to house cap and dep
        //NY24/222 Miss. Sinidi Bollegala - cap. calypso, NY24/262 Mr. Venuja Nethmira - dep.
        //NY24/046 Mr. Indusha Nirmith Sandaruwan - cap. Eurus, NY24/177 Mr. Pansilu Bimsara Menuja - dep
        //NY24/049 Mr. Thinuka Hathurusingha - cap. Tellus, NY24/190 Miss. Thewmi Sehansa Geeganage - dep
        //NY24/041 Miss. Linaya Dewlini Atapattu - cap. vulkan, NY24/093 Mr. Sahas Dewmin Sadeesha Widanage - dep.
        Student::whereIn("admission_number", ["NY24/222", "NY24/262"])->update(["school_house_id" => 4]);
        Student::whereIn("admission_number", ["NY24/046", "NY24/177"])->update(["school_house_id" => 3]);
        Student::whereIn("admission_number", ["NY24/049", "NY24/190"])->update(["school_house_id" => 2]);
        Student::whereIn("admission_number", ["NY24/041", "NY24/093"])->update(["school_house_id" => 1]);

        // 3. assign houses to students except house cap & dep, head pref & dep, games cap & dep
        // (also except EY1, EY2, EY3 students)
        $houseCapAndDep = ["NY24/222", "NY24/262", "NY24/046", "NY24/177", "NY24/049", "NY24/190", "NY24/041", "NY24/093"];
        $boyHeadPrefAndDep = ["NY24/183", "NY24/095"]; // Mr. Pujana Seneth Bandara Ekanayake, Mr. Yomith Devram Jayasooriya
        $girlHeadPrefAndDep = ["NY24/128", "NY24/160"]; // Miss. Praharshi Viwarthana Wirarathna, Miss. Mithara Sayumdee Pattiwila
        $gamesCapAndDep = ["NY24/146", "NY24/145"]; // Mr. Sanuka Siyasara Perera, Mr. Rahal Maithri Weerathna

        // $data = [];
        // $data['grade_level_id'] = $request->all()['grade_level_id'];

        $grade_level_list = GradeLevel::whereNotIn("id", [13, 14, 15])->get();
        foreach ($grade_level_list as $grade_level) {
            $student_list = Student::whereNotIn("admission_number", array_merge($houseCapAndDep, $boyHeadPrefAndDep, $girlHeadPrefAndDep, $gamesCapAndDep))->where("grade_level_id", $grade_level->id)->orderBy("admission_number_digits", "asc")->get();
            $last_assigned_school_house_id = 0;
            foreach ($student_list as $student) {
                if ($last_assigned_school_house_id == 4) {
                    $student->update(["school_house_id" => 1]);
                    $last_assigned_school_house_id = 1;
                } else {
                    $student->update(["school_house_id" => $last_assigned_school_house_id + 1]);
                    $last_assigned_school_house_id = $last_assigned_school_house_id + 1;
                }
            }
        }
        return ['status' => 'successful'];
    }

    function attachUserTypeToUser()
    {
        $user_list = User::get();
        $educator_user_type = UserType::where("name", "=", "Educator")->first();
        foreach ($user_list as $user) {
            $user->user_type_list()->syncWithoutDetaching([$educator_user_type->id]);
        }
        return ['status' => 'successful'];
    }
    function changePassword()
    {
        $user = User::where("id", "=", 49)->first();
        $user->update(['password' => Hash::make("nadeeshaf8965")]);
        return ['status' => 'successful'];
    }

    // update calling name for all students
    function assignCallingNameToStudent()
    {
        $student_calling_name_list = DB::table('student_calling_name_temp')->get();
        foreach ($student_calling_name_list as $item) {
            $student = Student::where("admission_number", $item->admission_number)->first();
            $student->update(["student_calling_name" => $item->calling_name]);
        }
        return ['status' => 'successful'];
    }


    // for all students from grade 4 upwards (student supply = A4 Sheet Bundle)
    function createStudentSupplyNotes()
    {
        $student_list = Student::where("has_dropped_out", "=", false)->where("grade_level_id", ">", 5)->where("grade_level_id", "<", 13)->orderBy('admission_number', 'asc')->get();
        $data = [];
        foreach ($student_list as $student) {
            $data['date'] = "2025-02-15";
            $data['student_id'] = $student->id;
            $data['student_supply_id'] = 1;
            $data['quantity'] = 1;
            $data['period_start_date'] = "2025-02-01";
            $data['period_end_date'] = "2025-02-28";
            $createStudentSupplyNoteUserDTO = CreateStudentSupplyNoteUserDTO::validate($data);
            $createStudentSupplyNoteActionData = [
                'created_by' => 1,
            ];
            CreateStudentSupplyNoteAction::run($createStudentSupplyNoteUserDTO, $createStudentSupplyNoteActionData);
        }

        // dd($data);
        // $grade_level_class_id = 1;
        // foreach ($educator_list as $educator) {
        //     $educator->grade_level_class_list()->syncWithoutDetaching([$grade_level_class_id]);
        // }
        return ['status' => 'successful'];
    }

    function attachGradeLevelClassToEducator()
    {
        $educator_list = Educator::with('subject_list.program.grade_level.grade_level_class_list')->get();
        $data = [];
        foreach ($educator_list as $educator) {
            foreach ($educator->subject_list as $subject) {
                foreach ($subject->program->grade_level->grade_level_class_list as $grade_level_class) {
                    // array_push($data, $grade_level_class->name);
                    $educator->grade_level_class_list()->syncWithoutDetaching([$grade_level_class->id]);
                }
            }
        }

        // dd($data);
        // $grade_level_class_id = 1;
        // foreach ($educator_list as $educator) {
        //     $educator->grade_level_class_list()->syncWithoutDetaching([$grade_level_class_id]);
        // }
        return ['status' => 'successful'];
    }

    function migrateOldReceiptVouchers()
    {
        $distinct_bill_list = DB::table('student_payment')->select('bill_number')->distinct('bill_number')->get();
        // dd($distinct_bill_list);
        // $records_1_to_50 = array_slice($distinct_bill_list->toArray(), 0, 50);
        // $records_51_to_100 = array_slice($distinct_bill_list->toArray(), 50, 100);
        // dd($records_51_to_100);
        // 174 = 2
        // 251 = 2
        // 908 = 3
        // 1124 = 3
        // 1239 = 3

        // admission_number
        // full_name
        // payment_method
        // bill_number
        // payment_received_date
        // admission_fee_settlement
        // refundable_deposit_settlement
        // term_fee_settlement
        // id
        // narration

        foreach ($distinct_bill_list as $distinct_bill) {
            if ($distinct_bill->bill_number == 174) { // 2
                $receiptVoucher1 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher2 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            } else if ($distinct_bill->bill_number == 251) { // 2
                $receiptVoucher1 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher2 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher3 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            } else if ($distinct_bill->bill_number == 908) { // 3
                $receiptVoucher1 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher2 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher3 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            } else if ($distinct_bill->bill_number == 1124) { // 3
                $receiptVoucher1 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher2 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher3 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            } else if ($distinct_bill->bill_number == 1239) { // 3
                $receiptVoucher1 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher2 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
                $receiptVoucher3 = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            } else {
                $receiptVoucher = $this->createReceiptVoucherFromOldDataHelper($distinct_bill);
            }
        }
    }

    function createReceiptVoucherFromOldDataHelper($distinct_bill)
    {
        $data = [];
        $data['created_by'] = "40";
        $data['receipt_party'] = "Student";
        $data['remarks'] = "Old data migration 23 Dec 2024";
        $data['payment_received_by_id'] = 8;
        $data['receipt_voucher_status_type_id'] = 1;
        $data['payment_method'] = "Cash";
        $data['cash_account_id'] = 1;
        $data['amount'] = 0;
        $data['narration'] = "";

        $bill_list = DB::table('student_payment')->where('bill_number', $distinct_bill->bill_number)->get();
        foreach ($bill_list as $bill) {
            $student = DB::table('student')->where('admission_number', $bill->admission_number)->first();
            $data['student_id'] = $student->id;
            $data['old_bill_number'] = $bill->bill_number;
            $data['narration'] .= "<p>$bill->narration</p>";
            $data['cash_received_date'] = $bill->payment_received_date;
            $data['payment_received_date'] = $bill->payment_received_date;
            if ($bill->admission_fee_settlement != null && $bill->admission_fee_settlement > 0) {
                $data['admission_fee_settlement'] = $bill->admission_fee_settlement;
                $data['amount'] += $bill->admission_fee_settlement;
            } else if ($bill->refundable_deposit_settlement != null && $bill->refundable_deposit_settlement > 0) {
                $data['refundable_deposit_settlement'] = $bill->refundable_deposit_settlement;
                $data['amount'] += $bill->refundable_deposit_settlement;
            } else if ($bill->term_fee_settlement != null && $bill->term_fee_settlement > 0) {
                $data['term_fee_settlement'] = $bill->term_fee_settlement;
                $data['amount'] += $bill->term_fee_settlement;
            }
        }

        $system_data['serial_number_prefix'] = "NY/REC";

        $maxDigits = ReceiptVoucher::where(function (Builder $receipt_query) {
            $serial_number_financial_year = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
            $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
        })->max("serial_number_digits");

        if ($maxDigits > 0) {
            $serial_number_digits = (int) $maxDigits + 1;
        } else {
            $serial_number_digits = 1;
        }
        $system_data['serial_number_digits'] = $serial_number_digits;
        $system_data['serial_number_current_year'] = date('y');
        $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
        $system_data['serial_number_suffix'] = '';
        if ($system_data['serial_number_suffix'] == '') {
            $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
        } else {
            $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
        }

        return ReceiptVoucher::create(array_merge($data, $system_data));
    }

    function updateAdmissionFeeReciptVoucherLinkData()
    {
        $receipt_vouchers = ReceiptVoucher::where('is_active', true)->get();
        $admission = AdmissionFeeInvoice::get();
        foreach ($receipt_vouchers as $receipt_voucher) {
            foreach ($admission as $admission_fee_invoice) {
                if ($receipt_voucher->student_id == $admission_fee_invoice->student_id) {
                    if ($receipt_voucher->admission_fee_invoice_id == null && $receipt_voucher->admission_fee_settlement > 0) {
                        $updateData = [
                            'admission_fee_invoice_id' => $admission_fee_invoice->id,
                        ];
                        $receipt_voucher->update($updateData);
                    }
                }
            }
        }
    }
    function updateRefundubleDepositOldData()
    {
        $receipt_vouchers = ReceiptVoucher::where('is_active', true)->get();
        $refundable_deposit = RefundableDeposit::get();
        foreach ($receipt_vouchers as $receipt_voucher) {
            foreach ($refundable_deposit as $refundable_deposit_invoice) {
                if ($receipt_voucher->student_id == $refundable_deposit_invoice->student_id) {
                    if ($receipt_voucher->refundable_deposit_invoice_id == null && $receipt_voucher->refundable_deposit_settlement > 0) {
                        $updateData = [
                            'refundable_deposit_id' => $refundable_deposit_invoice->id,
                        ];
                        $receipt_voucher->update($updateData);
                    }
                }
            }
        }
    }

    function updateAdmissionFeeInvoiceCompleteStatus()
    {
        $student_list = Student::with('receipt_voucher_list')->with('admission_fee_invoice_list')->get();
        //dd($student_list);
        foreach ($student_list as $student) {
            $student_receipt_voucher_sum = $student->receipt_voucher_list->sum('admission_fee_settlement');
            if (($student->approved_admission_fee - $student_receipt_voucher_sum) == 10 || ($student->approved_admission_fee - $student_receipt_voucher_sum) < 10) {
                AdmissionFeeInvoice::where('student_id', $student->id)->update(['is_admission_fee_invoice_complete' => true]);
            } else {
                AdmissionFeeInvoice::where('student_id', $student->id)->update(['is_admission_fee_invoice_complete' => false]);
            }
        }
        return ['status' => 'successful'];
    }
    function updateRefundableDepositCompleteStatus()
    {
        $student_list = Student::with('receipt_voucher_list')->with('refundable_deposit_list')->get();
        //dd($student_list);
        foreach ($student_list as $student) {
            $student_receipt_voucher_sum = $student->receipt_voucher_list->sum('refundable_deposit_settlement');
            if (($student->applicable_refundable_deposit - $student_receipt_voucher_sum) == 10 || ($student->applicable_refundable_deposit - $student_receipt_voucher_sum) < 10) {
                RefundableDeposit::where('student_id', $student->id)->update(['is_refundable_deposit_complete' => true]);
            } else {
                RefundableDeposit::where('student_id', $student->id)->update(['is_refundable_deposit_complete' => false]);
            }
        }
        return ['status' => 'successful'];
    }

    // function updateTermFeeInvoicesOldData()
    // {
    //     $receipt_vouchers = ReceiptVoucher::where('is_active', true)->where('payment_received_date', '<=', "2024-12-31")->get();
    //     // $receipt_vouchers = ReceiptVoucher::where('is_active', true)->where('payment_received_date', '>', "2024-12-31")->where('payment_received_date', '<=', "2025-03-31")->get();
    //     // $receipt_vouchers = ReceiptVoucher::where('is_active', true)->where('payment_received_date', '>=', "2025-04-01")->get();
    //     $term_fee_invoices = TermFeeInvoice::get();
    //     foreach ($receipt_vouchers as $receipt_voucher) {
    //         foreach ($term_fee_invoices as $term_fee_invoices_invoice) {
    //             if ($receipt_voucher->student_id == $term_fee_invoices_invoice->student_id) {
    //                 if ($receipt_voucher->term_fee_invoices_invoice_id == null && $receipt_voucher->term_fee_settlement > 0) {
    //                     $updateData = [
    //                         'term_fee_invoice_id' => $term_fee_invoices_invoice->id,
    //                     ];
    //                     $receipt_voucher->update($updateData);
    //                 }
    //             }
    //         }
    //     }
    // }
    function updateTermFeeCompleteStatus()
    {
        // $student_list = Student::with('receipt_voucher_list')->with('term_fee_invoice_list')->get();
        // //dd($student_list);
        // foreach ($student_list as $student) {
        //     $student_receipt_voucher_sum = $student->receipt_voucher_list->sum('term_fee_settlement');
        //     if (($student->applicable_term_payment - $student_receipt_voucher_sum) == 10 || ($student->applicable_term_payment - $student_receipt_voucher_sum) < 10) {
        //         TermFeeInvoice::where('student_id', $student->id)->update(['is_term_fee_invoice_complete' => true]);
        //     } else {
        //         TermFeeInvoice::where('student_id', $student->id)->update(['is_term_fee_invoice_complete' => false]);
        //     }
        // }
        $termFeeInvoice = TermFeeInvoice::get();
        foreach ($termFeeInvoice as $termFeeInvoiceData) {
            $reciptVoucher = TermFeePayment::where('term_fee_invoice_id', $termFeeInvoiceData->id)->where('term_id', 3)->sum('paid_amount');
            if ($termFeeInvoiceData->bill_total - $reciptVoucher == 10 || $termFeeInvoiceData->bill_total - $reciptVoucher < 10) {
                TermFeeInvoice::where('id', $termFeeInvoiceData->id)->update(['is_term_fee_invoice_complete' => true]);
            }
            // else {
            //     TermFeeInvoice::where('id', $termFeeInvoiceData->id)->update(['is_term_fee_invoice_complete' => false]);
            // }
        }
        return ['status' => 'successful'];
    }

    function populateJoinedTermColumnInStudentTable()
    {
        try {
            $studentListWhoHasTermFeeInvoices = Student::whereHas('term_fee_invoice_list', function ($q) {})->with(['term_fee_invoice_list' => function (Builder $term_fee_invoice_list_query) {
                return $term_fee_invoice_list_query->select("id", "student_id", "term_id")->orderBy('term_id', 'asc');
            }])->get();
            foreach ($studentListWhoHasTermFeeInvoices as $student) {
                $student->joined_term_id = $student->term_fee_invoice_list->first()->term_id;
                $student->save();
            }

            return ['status' => 'successful'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    function populateTermFeePaymentTable()
    {
        try {
            $studentListWhoPaidTermFee = Student::whereHas('receipt_voucher_list', function ($q) {
                return $q->where('term_fee_settlement', '>', 0);
            })->get();
            foreach ($studentListWhoPaidTermFee as $student) {
                $allTermFeeReceiptVouchers = ReceiptVoucher::where('student_id', $student->id)->where('term_fee_settlement', '>', 0)->with('student')->orderBy('payment_received_date', 'Asc')->get();
                $schoolYear = "24-25";
                $termNumber = $student->joined_term_id;
                $sumOfLessPayments = 0;
                foreach ($allTermFeeReceiptVouchers as $termFeeReceiptVoucher) {
                    $studentApplicableTermFee = $termFeeReceiptVoucher->student->applicable_term_payment;
                    // if paid extra
                    if (($studentApplicableTermFee - $termFeeReceiptVoucher->term_fee_settlement) < 0) {
                        $paidAmount = $termFeeReceiptVoucher->term_fee_settlement;
                        $maxTermNumber = intdiv($termFeeReceiptVoucher->term_fee_settlement, $studentApplicableTermFee);
                        while ($paidAmount > 0) {
                            TermFeePayment::create([
                                "school_year" => $schoolYear,
                                "term" => $termNumber,
                                "term_id" => $termNumber > 3 ? null : $termNumber,
                                "paid_amount" => $paidAmount > $studentApplicableTermFee ? $studentApplicableTermFee : $paidAmount,
                                "receipt_voucher_id" => $termFeeReceiptVoucher->id,
                                "receipt_voucher_serial_number" => $termFeeReceiptVoucher->serial_number,
                                "student_id" => $student->id,
                                "student_admission_number" => $student->admission_number,
                            ]);
                            // if term number < 3 then increment termNumber
                            if ($termNumber <> $maxTermNumber) {
                                $termNumber++;
                            }
                            $paidAmount = $paidAmount - $studentApplicableTermFee;
                        }
                    } else { // not paid extra
                        // if paid less
                        if ($studentApplicableTermFee > $termFeeReceiptVoucher->term_fee_settlement) {
                            if (($sumOfLessPayments + $termFeeReceiptVoucher->term_fee_settlement) > $studentApplicableTermFee) {
                                TermFeePayment::create([
                                    "school_year" => $schoolYear,
                                    "term" => $termNumber,
                                    "term_id" => $termNumber > 3 ? null : $termNumber,
                                    "paid_amount" => $studentApplicableTermFee - $sumOfLessPayments,
                                    "receipt_voucher_id" => $termFeeReceiptVoucher->id,
                                    "receipt_voucher_serial_number" => $termFeeReceiptVoucher->serial_number,
                                    "student_id" => $student->id,
                                    "student_admission_number" => $student->admission_number,
                                ]);
                                TermFeePayment::create([
                                    "school_year" => $schoolYear,
                                    "term" => $termNumber + 1,
                                    "term_id" => $termNumber + 1 > 3 ? null : $termNumber + 1,
                                    "paid_amount" => $termFeeReceiptVoucher->term_fee_settlement - ($studentApplicableTermFee - $sumOfLessPayments),
                                    "receipt_voucher_id" => $termFeeReceiptVoucher->id,
                                    "receipt_voucher_serial_number" => $termFeeReceiptVoucher->serial_number,
                                    "student_id" => $student->id,
                                    "student_admission_number" => $student->admission_number,
                                ]);
                                $sumOfLessPayments = 0;
                                $termNumber++;
                            } else {
                                TermFeePayment::create([
                                    "school_year" => $schoolYear,
                                    "term" => $termNumber,
                                    "term_id" => $termNumber > 3 ? null : $termNumber,
                                    "paid_amount" => $termFeeReceiptVoucher->term_fee_settlement,
                                    "receipt_voucher_id" => $termFeeReceiptVoucher->id,
                                    "receipt_voucher_serial_number" => $termFeeReceiptVoucher->serial_number,
                                    "student_id" => $student->id,
                                    "student_admission_number" => $student->admission_number,
                                ]);
                                $sumOfLessPayments = $sumOfLessPayments + $termFeeReceiptVoucher->term_fee_settlement;
                            }
                        } else { // paid exact applicable fee
                            TermFeePayment::create([
                                "school_year" => $schoolYear,
                                "term" => $termNumber,
                                "term_id" => $termNumber > 3 ? null : $termNumber,
                                "paid_amount" => $termFeeReceiptVoucher->term_fee_settlement,
                                "receipt_voucher_id" => $termFeeReceiptVoucher->id,
                                "receipt_voucher_serial_number" => $termFeeReceiptVoucher->serial_number,
                                "student_id" => $student->id,
                                "student_admission_number" => $student->admission_number,
                            ]);
                            $termNumber++;
                        }
                    }
                }
            }

            return ['status' => 'successful'];
        } catch (\Throwable $th) {
            throw $th;
            // return ['status' => 'failed'];
        }
    }

    function insertSportFeeInvoices()
    {
        // $createSportFeeInvoiceUserDTO = CreateSportFeeInvoiceUserDTO::validate($payloadArray);

        $studentList = Student::where(function (Builder $student_list_query) {
            // $student_list_query->where("grade_level_id", ">=", 6)->where("grade_level_id", "<=", 9)->where("has_dropped_out", false)->orderBy('grade_level_id', 'asc');
            $student_list_query->whereIn("admission_number", [
                "NY24/326",
                "NY24/028",
                "NY24/001",
                "NY24/027",
                "NY24/007",
                "NY24/339",
                "NY24/336",
                "NY24/312",
                "NY24/030",
                "NY24/243",
                "NY24/126",
                "NY24/037",
                "NY24/125",
                "NY24/174",
                "NY24/157",
                "NY24/090",
                "NY24/056",
                "NY24/005",
                "NY24/013",
                "NY24/082",
                "NY24/014",
                "NY24/240",
                "NY24/099",
                "NY24/034",
                "NY24/038",
                "NY24/276",
                "NY24/043",
                "NY24/340"
            ])->orderBy('grade_level_id', 'asc');
        })->get();
        // var_dump($studentList);
        if (count($studentList) > 0) {
            foreach ($studentList as $studentListdata) {
                // var_dump($studentListdata['id']);
                $system_data['serial_number_prefix'] = "NY/SP-INV";
                $maxDigits = SportFeeInvoice::where(function (Builder $receipt_query) {
                    $serial_number_financial_year = (date('m') > 1) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                    $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
                })->max("serial_number_digits");

                if ($maxDigits > 0) {
                    $serial_number_digits = (int) $maxDigits + 1;
                } else {
                    $serial_number_digits = 1;
                }
                $system_data['serial_number_digits'] = $serial_number_digits;
                $system_data['serial_number_current_year'] = date('y');
                $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                $system_data['serial_number_suffix'] = '';
                if ($system_data['serial_number_suffix'] == '') {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
                } else {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
                }
                $system_data['created_by'] = 1;
                $system_data['term_id'] = 3;

                $createSportFeeInvoiceSystemDTO = CreateSportFeeInvoiceSystemDTO::validate($system_data);
                $sportData['student_id'] = $studentListdata['id'];
                $sportData['date'] = date('Y-m-d');
                $sportData['items_total'] = 8000;
                $sportData['bill_total'] = 8000;
                $createSportFeeInvoiceDTO = CreateSportFeeInvoiceDTO::validate(array_merge($sportData, $createSportFeeInvoiceSystemDTO));
                $createdSportFeeInvoice = SportFeeInvoice::create($createSportFeeInvoiceDTO);

                // invoice item
                $sportFeeInvoiceItemData = [];
                $sportFeeInvoiceItemData['sport_fee_invoice_id'] = $createdSportFeeInvoice->id;
                // $sportFeeInvoiceItemData['school_fee_id'] = $schoolFee->id;
                $sportFeeInvoiceItemData['description'] = "Sport Fee";
                $sportFeeInvoiceItemData['is_sport_fee_invoice_item_complete'] = false;
                $sportFeeInvoiceItemData['unit_price'] = 2000;
                $sportFeeInvoiceItemData['qty'] = 4;
                $sportFeeInvoiceItemData['item_total'] = 8000;

                $createSportFeeInvoiceItemUserDTO = CreateSportFeeInvoiceItemUserDTO::validate($sportFeeInvoiceItemData);
                $sportFeeInvoiceItemActionData = ['created_by' => 1];
                CreateSportFeeInvoiceItemAction::run($createSportFeeInvoiceItemUserDTO, $sportFeeInvoiceItemActionData);
            }
        }
    }
    function updateSportFeeInvoiceReciptVoucherLinkData()
    {
        $receipt_vouchers = ReceiptVoucher::where('is_active', true)->get();
        $sport_fee_invoice = SportFeeInvoice::get();
        foreach ($receipt_vouchers as $receipt_voucher) {
            foreach ($sport_fee_invoice as $sport_fee_invoice_data) {
                if ($receipt_voucher->student_id == $sport_fee_invoice_data->student_id) {
                    if ($receipt_voucher->sport_fee_invoice_id == null && $receipt_voucher->sport_fee > 0) {
                        $updateData = [
                            'sport_fee_invoice_id' => $sport_fee_invoice_data->id,
                        ];
                        $receipt_voucher->update($updateData);
                    }
                }
            }
        }
    }

    function insertTermFeeInvoices()
    {
        // $studentList = Student::where(function (Builder $student_list_query) {
        //     $student_list_query->where("has_dropped_out", false);
        //     // $student_list_query->where("has_dropped_out", false)->where('joined_date', '<=', '2025-01-31');
        //     // $student_list_query->where('joined_date', '<=', '2024-12-31');
        // })->get();
        $studentList = DB::table('temp_term_fee_invoice_data')->get();
        // var_dump($studentList);
        if (count($studentList) > 0) {
            foreach ($studentList as $studentListdata) {
                // dd($studentListdata);
                $system_data['serial_number_prefix'] = "NY/TF-INV";
                $maxDigits = TermFeeInvoice::where(function (Builder $receipt_query) {
                    $serial_number_financial_year = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                    $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
                })->max("serial_number_digits");

                if ($maxDigits > 0) {
                    $serial_number_digits = (int) $maxDigits + 1;
                } else {
                    $serial_number_digits = 1;
                }
                $system_data['serial_number_digits'] = $serial_number_digits;
                $system_data['serial_number_current_year'] = date('y');
                $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                $system_data['serial_number_suffix'] = '';
                if ($system_data['serial_number_suffix'] == '') {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
                } else {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
                }
                $system_data['created_by'] = 1;
                $createTermFeeInvoiceSystemDTO = CreateTermFeeInvoiceSystemDTO::validate($system_data);

                $termFeeData['student_id'] = $studentListdata->student_id;
                $termFeeData['items_total'] = $studentListdata->amount;
                $termFeeData['service_charges_total'] = 0;
                $termFeeData['subtotal_before_discount'] = $studentListdata->amount;
                $termFeeData['discount_total'] = 0;
                $termFeeData['subtotal_after_discount'] = $studentListdata->amount;
                $termFeeData['bill_total'] = $studentListdata->amount;
                $termFeeData['term_id'] = $studentListdata->term_id;
                $termFeeData['date'] = "2025-05-17";

                $createTermFeeInvoiceDTO = CreateTermFeeInvoiceDTO::validate(array_merge($termFeeData, $createTermFeeInvoiceSystemDTO));
                $createdTermFeeInvoice = TermFeeInvoice::create($createTermFeeInvoiceDTO);

                // item
                $item['term_fee_invoice_id'] = $createdTermFeeInvoice->id; // Assign term_fee_invoice_id
                $item['term_id'] = $studentListdata->term_id;
                $item['grade_level_id'] = $studentListdata->grade_level_id;
                $item['item_total'] = $studentListdata->amount;
                $createTermFeeInvoiceItemUserDTO = CreateTermFeeInvoiceItemUserDTO::validate($item);
                $termFeeInvoiceItemActionData = ['created_by' => 1];
                CreateTermFeeInvoiceItemAction::run($createTermFeeInvoiceItemUserDTO, $termFeeInvoiceItemActionData);
            }
        }
    }

    function attachTermFeeInvoiceToTermFeePaymentTable()
    {
        try {
            $allTermFeeInvoiceList = TermFeeInvoice::get();
            foreach ($allTermFeeInvoiceList as $termFeeInvoice) {
                $studentTermFeePaymentList = TermFeePayment::where('term_id', '=', $termFeeInvoice->term_id)->where('student_id', $termFeeInvoice->student_id)->get();
                foreach ($studentTermFeePaymentList as $termFeePayment) {
                    $termFeePayment->update([
                        "term_fee_invoice_id" => $termFeeInvoice->id
                    ]);
                }
            }

            return ['status' => 'successful'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function insertAdmissionFeeInvoices()
    {
        $studentList = Student::where(function (Builder $student_list_query) {
            // $student_list_query->where("grade_level_id", 15)->where("has_dropped_out", false);
        })->get();
        // var_dump($studentList);
        if (count($studentList) > 0) {
            foreach ($studentList as $studentListdata) {
                // var_dump($studentListdata['id']);
                $system_data['serial_number_prefix'] = "NY/ADM-INV";
                $maxDigits = AdmissionFeeInvoice::where(function (Builder $receipt_query) {
                    $serial_number_financial_year = (date('m') > 1) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                    $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
                })->max("serial_number_digits");

                if ($maxDigits > 0) {
                    $serial_number_digits = (int) $maxDigits + 1;
                } else {
                    $serial_number_digits = 1;
                }
                $system_data['serial_number_digits'] = $serial_number_digits;
                $system_data['serial_number_current_year'] = date('y');
                $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                $system_data['serial_number_suffix'] = '';
                if ($system_data['serial_number_suffix'] == '') {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
                } else {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
                }
                $system_data['created_by'] = 1;

                $createAdmissionFeeInvoiceSystemDTO = CreateAdmissionFeeInvoiceSystemDTO::validate($system_data);
                $admissionData['student_id'] = $studentListdata['id'];
                $admissionData['date'] = date('Y-m-d');
                $admissionData['items_total'] = $studentListdata['approved_admission_fee'];
                $admissionData['bill_total'] = $studentListdata['approved_admission_fee'];
                $createAdmissionFeeInvoiceDTO = CreateAdmissionFeeInvoiceDTO::validate(array_merge($admissionData, $createAdmissionFeeInvoiceSystemDTO));
                $createdAdmissionFeeInvoice = AdmissionFeeInvoice::create($createAdmissionFeeInvoiceDTO);
                // invoice item
                $admissionFeeInvoiceData = [];
                $admissionFeeInvoiceData['admission_fee_invoice_id'] = $createdAdmissionFeeInvoice->id;
                // $admissionFeeInvoiceData['school_fee_id'] = $schoolFee->id;
                $admissionFeeInvoiceData['description'] = "Admission Fee";
                $admissionFeeInvoiceData['is_admission_fee_invoice_item_complete'] = false;
                $admissionFeeInvoiceData['item_total'] =  $studentListdata['approved_admission_fee'];

                $createAdmissionFeeInvoiceItemUserDTO = CreateAdmissionFeeInvoiceItemUserDTO::validate($admissionFeeInvoiceData);
                $admissionFeeInvoiceItemActionData = ['created_by' => 1];
                CreateAdmissionFeeInvoiceItemAction::run($createAdmissionFeeInvoiceItemUserDTO, $admissionFeeInvoiceItemActionData);
            }
        }
    }

    function insertRefundableDeposits()
    {
        $studentList = Student::where(function (Builder $student_list_query) {
            // $student_list_query->where("grade_level_id", 19)->where("has_dropped_out", false);
        })->get();
        // var_dump($studentList);
        if (count($studentList) > 0) {
            foreach ($studentList as $studentListdata) {
                $system_data['serial_number_prefix'] = "NY/REF-INV";
                $maxDigits = RefundableDeposit::where(function (Builder $receipt_query) {
                    $serial_number_financial_year = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                    $receipt_query->where("serial_number_financial_year", "=", $serial_number_financial_year);
                })->max("serial_number_digits");

                if ($maxDigits > 0) {
                    $serial_number_digits = (int) $maxDigits + 1;
                } else {
                    $serial_number_digits = 1;
                }
                $system_data['serial_number_digits'] = $serial_number_digits;
                $system_data['serial_number_current_year'] = date('y');
                $system_data['serial_number_financial_year'] = (date('m') > 3) ? date('y') . '-' . (date('y') + 1) : (date('y') - 1) . '-' . date('y');
                $system_data['serial_number_suffix'] = '';
                if ($system_data['serial_number_suffix'] == '') {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'];
                } else {
                    $system_data['serial_number'] = $system_data['serial_number_prefix'] . "/" . $system_data['serial_number_current_year'] . "/" . $system_data['serial_number_financial_year'] . "/" . $system_data['serial_number_digits'] . "/" . $system_data['serial_number_suffix'];
                }
                $system_data['created_by'] = 1;

                $createRefundableDepositSystemDTO = CreateRefundableDepositSystemDTO::validate($system_data);
                $admissionData['student_id'] = $studentListdata['id'];
                $admissionData['date'] = date('Y-m-d');
                $admissionData['subtotal_before_discount'] = 0;
                $admissionData['discount_total'] = 0;
                $admissionData['subtotal_after_discount'] = 0;
                $admissionData['items_total'] = $studentListdata['applicable_refundable_deposit'];
                $admissionData['bill_total'] = $studentListdata['applicable_refundable_deposit'];
                $createRefundableDepositDTO = CreateRefundableDepositDTO::validate(array_merge($admissionData, $createRefundableDepositSystemDTO));
                $createdRefundableDeposit = RefundableDeposit::create($createRefundableDepositDTO);

                $refundableDepositData = [];
                $refundableDepositData['refundable_deposit_id'] = $createdRefundableDeposit->id;
                // $refundableDepositData['school_fee_id'] = $schoolFee->id;
                $refundableDepositData['description'] = "Refundable Deposit";
                $refundableDepositData['is_refundable_deposit_item_complete'] = false;
                $refundableDepositData['item_total'] = $studentListdata['applicable_refundable_deposit'];

                $createRefundableDepositItemUserDTO = CreateRefundableDepositItemUserDTO::validate($refundableDepositData);
                $refundableDepositItemActionData = ['created_by' => 1];
                CreateRefundableDepositItemAction::run($createRefundableDepositItemUserDTO, $refundableDepositItemActionData);
            }
        }
    }
    function overpaidTermFeeInvoiceList()
    {
        $overpaidTermFeeInvoiceList = [];
        $allTermFeeInvoiceList = TermFeeInvoice::with('term_fee_payment_list')->get();
        foreach ($allTermFeeInvoiceList as $termFeeInvoice) {
            $sumOfPaidAmount = $termFeeInvoice->term_fee_payment_list->sum('paid_amount');
            if ($sumOfPaidAmount > $termFeeInvoice->bill_total) {
                array_push($overpaidTermFeeInvoiceList, $termFeeInvoice->serial_number);
            }
        }
        dd($overpaidTermFeeInvoiceList);
    }
}
