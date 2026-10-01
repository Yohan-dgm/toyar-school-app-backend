<?php

namespace Modules\AccountManagement\Intents\StudentPendingInvoice\GetStudentPendingInvoiceListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\ReceiptVoucher;
use Modules\StudentManagement\Models\Student;

class GetStudentPendingInvoiceListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // Student Pending Invoice Data Validation
        $getStudentPendingInvoiceListDataUserDTO = GetStudentPendingInvoiceListDataUserDTO::validate($payloadArray);

        // Get student by name or admission number
        $studentQuery = Student::where('has_dropped_out', false)
            ->where('is_school_leaver', false);

        if (!empty($getStudentPendingInvoiceListDataUserDTO['student_name'])) {
            $studentQuery->where('full_name', 'ILIKE', '%' . $getStudentPendingInvoiceListDataUserDTO['student_name'] . '%');
        }

        if (!empty($getStudentPendingInvoiceListDataUserDTO['admission_number'])) {
            $admissionNumbers = is_array($getStudentPendingInvoiceListDataUserDTO['admission_number'])
                ? $getStudentPendingInvoiceListDataUserDTO['admission_number']
                : [$getStudentPendingInvoiceListDataUserDTO['admission_number']];

            $studentQuery->where(function ($query) use ($admissionNumbers) {
                foreach ($admissionNumbers as $admissionNumber) {
                    $query->orWhere('admission_number', 'ILIKE', '%' . $admissionNumber . '%');
                }
            });
        }

        $students = $studentQuery->get();

        $pendingInvoices = [];

        foreach ($students as $student) {
            $studentPendingInvoices = [];

            // Term Fee Invoices
            $termFeeInvoices = TermFeeInvoice::where('student_id', $student->id)
                ->with(['term'])
                ->with(['term_fee_payment_list' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            foreach ($termFeeInvoices as $invoice) {
                // Calculate actual payment status
                $totalPaid = $invoice->term_fee_payment_list->sum('paid_amount');
                $isPaid = $totalPaid >= $invoice->bill_total;

                // Only include if not fully paid and not zero amount
                if (!$isPaid && $invoice->bill_total != 0) {
                    $studentPendingInvoices[] = [
                        'invoice_type'        => 'Term Fee',
                        'invoice_id'          => $invoice->id,  // standardised field
                        'term_fee_invoice_id' => $invoice->id,  // kept for backward compatibility
                        'serial_number'       => $invoice->serial_number,
                        'date'                => $invoice->date,
                        'bill_total'          => $invoice->bill_total,
                        'term_name'           => $invoice->term->name ?? null,
                        'paid_amount'         => $totalPaid,
                        'balance_amount'      => $invoice->bill_total - $totalPaid,
                        'created_at'          => $invoice->created_at,
                    ];
                }
            }

            // Admission Fee Invoices
            $admissionFeeInvoices = AdmissionFeeInvoice::where('student_id', $student->id)
                ->with(['applicant', 'admission_fee_invoice_item_list', 'receipt_voucher_list' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            foreach ($admissionFeeInvoices as $invoice) {
                // Calculate actual payment status
                $totalPaid = $invoice->receipt_voucher_list->sum('amount');
                $isPaid = $totalPaid >= $invoice->bill_total;

                // Only include if not fully paid
                if (!$isPaid && $invoice->bill_total != 0) {
                    $studentPendingInvoices[] = [
                        'invoice_type' => 'Admission Fee',
                        'invoice_id' => $invoice->id,
                        'serial_number' => $invoice->serial_number,
                        'date' => $invoice->date,
                        'bill_total' => $invoice->bill_total,
                        'paid_amount' => $totalPaid,
                        'balance_amount' => $invoice->bill_total - $totalPaid,
                        'created_at' => $invoice->created_at,
                    ];
                }
            }

            // Exam Bills
            $examBills = ExamBill::where('student_id', $student->id)
                ->with(['exam_bill_item_list', 'receipt_voucher_list' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            foreach ($examBills as $bill) {
                // ExamBill payments are tracked via receipt_voucher_list (amount column)
                $totalPaid = $bill->receipt_voucher_list->sum('amount');
                $isPaid = $totalPaid >= $bill->total;

                if (!$isPaid && $bill->total != 0) {
                    $studentPendingInvoices[] = [
                        'invoice_type' => 'Exam Bill',
                        'invoice_id' => $bill->id,
                        'serial_number' => $bill->serial_number,
                        'date' => $bill->date,
                        'bill_total' => $bill->total,
                        'paid_amount' => $totalPaid,
                        'balance_amount' => $bill->total - $totalPaid,
                        'created_at' => $bill->created_at,
                    ];
                }
            }

            // Sport Fee Invoices
            $sportFeeInvoices = SportFeeInvoice::where('student_id', $student->id)
                ->with(['term', 'sport_fee_invoice_item_list'])
                ->with(['receipt_voucher_list' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            foreach ($sportFeeInvoices as $invoice) {
                // Calculate actual payment status
                $totalPaid = $invoice->receipt_voucher_list->sum('amount');
                $isPaid = $totalPaid >= $invoice->bill_total;

                // Only include if not fully paid
                if (!$isPaid && $invoice->bill_total != 0) {
                    $studentPendingInvoices[] = [
                        'invoice_type' => 'Sport Fee',
                        'invoice_id' => $invoice->id,
                        'serial_number' => $invoice->serial_number,
                        'date' => $invoice->date,
                        'bill_total' => $invoice->bill_total,
                        'term_name' => $invoice->term->name ?? null,
                        'paid_amount' => $totalPaid,
                        'balance_amount' => $invoice->bill_total - $totalPaid,
                        'created_at' => $invoice->created_at,
                    ];
                }
            }

            // Material Bills
            $materialBills = MaterialBill::where('student_id', $student->id)
                ->where('is_material_bill_complete', false)
                ->with(['material_bill_item_list', 'receipt_voucher_list' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->get();

            foreach ($materialBills as $bill) {
                // Calculate actual payment status using same logic as system
                $receiptVoucherSum = $bill->receipt_voucher_list->sum('amount');
                $isPaid = $receiptVoucherSum >= $bill->bill_total;

                if (!$isPaid && $bill->bill_total != 0) {
                    $studentPendingInvoices[] = [
                        'invoice_type' => 'Material Bill',
                        'invoice_id' => $bill->id,
                        'serial_number' => $bill->serial_number,
                        'date' => $bill->date,
                        'bill_total' => $bill->bill_total,
                        'items_total' => $bill->items_total,
                        'paid_amount' => $receiptVoucherSum,
                        'balance_amount' => $bill->bill_total - $receiptVoucherSum,
                        'created_at' => $bill->created_at,
                    ];
                }
            }


            if (!empty($studentPendingInvoices)) {
                $pendingInvoices[] = [
                    'student' => [
                        'id' => $student->id,
                        'full_name_with_title' => $student->full_name_with_title,
                        'admission_number' => $student->admission_number,
                        'grade_level_class' => $student->grade_level_class->name ?? null,
                    ],
                    'pending_invoices' => $studentPendingInvoices,
                    'total_pending_amount' => array_sum(array_column($studentPendingInvoices, 'balance_amount')),
                    'pending_invoice_count' => count($studentPendingInvoices)
                ];
            }
        }

        return $pendingInvoices;
    }
}
