<?php

namespace Modules\AccountManagement\Intents\StudentBillsData\GetStudentBillsData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AccountManagement\Models\AdmissionFeeInvoice;
use Modules\AccountManagement\Models\ExamBill;
use Modules\AccountManagement\Models\GeneralBill;
use Modules\AccountManagement\Models\MaterialBill;
use Modules\AccountManagement\Models\RefundableDeposit;
use Modules\AccountManagement\Models\SportFeeInvoice;
use Modules\AccountManagement\Models\TermFeeInvoice;
use Modules\StudentManagement\Models\Student;

class GetStudentBillsDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getStudentBillsDataUserDTO = GetStudentBillsDataUserDTO::validate($payloadArray);
        $studentIds = $getStudentBillsDataUserDTO['student_ids'];

        $studentBillsData = [];

        foreach ($studentIds as $studentId) {
            $studentBillsData["student_$studentId"] = [
                'student_info' => $this->getStudentInfo($studentId),
                'admission_fee_invoices' => $this->getAdmissionFeeInvoices($studentId),
                'term_fee_invoices' => $this->getTermFeeInvoices($studentId),
                'exam_bills' => $this->getExamBills($studentId),
                'sport_fee_invoices' => $this->getSportFeeInvoices($studentId),
                'refundable_deposits' => $this->getRefundableDeposits($studentId),
                'general_bills' => $this->getGeneralBills($studentId),
                'material_bills' => $this->getMaterialBills($studentId),
            ];
        }

        return GetStudentBillsDataResDTO::from([
            'student_bills_data' => $studentBillsData,
        ]);
    }

    private function getAdmissionFeeInvoices($studentId)
    {
        return AdmissionFeeInvoice::where('student_id', $studentId)
            ->with(['admission_fee_invoice_item_list'])
            ->select(
                'id',
                'student_id',
                'bill_total as admission_fee_invoice_amount',
                'discount_total as admission_fee_invoice_discount',
                'service_charges_total as admission_fee_invoice_tax',
                'subtotal_after_discount as admission_fee_invoice_net_amount',
                'date as admission_fee_invoice_date',
                'created_at'
            )
            ->get()
            ->toArray();
    }

    private function getTermFeeInvoices($studentId)
    {
        $invoices = TermFeeInvoice::where('student_id', $studentId)
            ->with([
                'term_fee_invoice_item_list.grade_level',
                'term_fee_invoice_item_list.term',
                'term_fee_invoice_item_list.school_fee',
                'term',
            ])
            ->select(
                'id',
                'student_id',
                'term_id',
                'date',
                'bill_total',
                'discount_total',
                'service_charges_total',
                'subtotal_after_discount',
                'items_total',
                'subtotal_before_discount',
                // 'tax_total',
                'serial_number',
                'is_term_fee_invoice_complete',
                'order_notes',
                'office_notes',
                'created_at'
            )
            ->get()
            ->toArray();

        $result = [];
        foreach ($invoices as $invoice) {
            // Format invoice header
            $header = $this->formatInvoiceHeader($invoice, 'term_fee_invoice');
            $header['term_info'] = $this->formatTermInfo($invoice['term']);
            $header['amount_breakdown'] = $this->formatAmountBreakdown($invoice);
            $header['notes'] = [
                'order_notes' => $invoice['order_notes'],
                'office_notes' => $invoice['office_notes'],
            ];

            // Format line items
            $lineItems = [];
            foreach ($invoice['term_fee_invoice_item_list'] as $item) {
                $lineItems[] = [
                    'id' => $item['id'],
                    'description' => $item['school_fee']['name'] ?? 'Term Fee',
                    'grade_level' => $item['grade_level']['name'] ?? null,
                    'grade_level_id' => $item['grade_level_id'],
                    'term_name' => $item['term']['name'] ?? null,
                    'amount' => $item['item_total'],
                    'category' => 'Term Fee',
                    'school_fee_info' => [
                        'id' => $item['school_fee']['id'] ?? null,
                        'name' => $item['school_fee']['name'] ?? null,
                        'type' => $item['school_fee']['school_fee_type'] ?? null,
                        'amount' => $item['school_fee']['amount'] ?? null,
                    ],
                ];
            }

            $result[] = [
                'invoice_header' => $header,
                'line_items' => $lineItems,
            ];
        }

        return $result;
    }

    private function getExamBills($studentId)
    {
        $bills = ExamBill::where('student_id', $studentId)
            ->with([
                'exam_bill_item_list.exam_subject_category',
                'exam_bill_item_list.exam_subject_list',
            ])
            ->select(
                'id',
                'student_id',
                'date',
                'bill_party',
                'total',
                'exam_bill_discount',
                'additional_service_charge',
                'subtotal',
                'exam_subjects_total',
                'exam_service_charges_total',
                'serial_number',
                'bill_notes',
                'office_notes',
                'created_at'
            )
            ->get()
            ->toArray();

        $result = [];
        foreach ($bills as $bill) {
            // Format bill header
            $header = $this->formatInvoiceHeader($bill, 'exam_bill');
            $header['amount_breakdown'] = [
                'exam_subjects_total' => $bill['exam_subjects_total'],
                'exam_service_charges_total' => $bill['exam_service_charges_total'],
                'additional_service_charge' => $bill['additional_service_charge'],
                'subtotal' => $bill['subtotal'],
                'discount' => $bill['exam_bill_discount'],
                'total' => $bill['total'],
            ];
            $header['bill_party'] = $bill['bill_party'];
            $header['notes'] = [
                'bill_notes' => $bill['bill_notes'],
                'office_notes' => $bill['office_notes'],
            ];

            // Format line items with subject categories and subjects
            $lineItems = [];
            foreach ($bill['exam_bill_item_list'] as $item) {
                $subjects = [];
                foreach ($item['exam_subject_list'] as $subject) {
                    $subjects[] = [
                        'id' => $subject['id'],
                        'name' => $subject['name'] ?? 'Subject',
                        'code' => $subject['code'] ?? null,
                    ];
                }

                $lineItems[] = [
                    'id' => $item['id'],
                    'subject_category' => [
                        'id' => $item['exam_subject_category']['id'] ?? null,
                        'name' => $item['exam_subject_category']['name'] ?? 'Subject Category',
                        'description' => $item['exam_subject_category']['description'] ?? null,
                    ],
                    'subjects' => $subjects,
                    'subject_count' => count($subjects),
                    'rate_per_subject' => count($subjects) > 0 ? ($item['total'] / count($subjects)) : 0,
                    'subtotal' => $item['subtotal'],
                    'total_amount' => $item['total'],
                    'rate_details' => [
                        'rate_id_list' => $item['rate_id_list'],
                        'rate_list' => $item['rate_list'],
                    ],
                ];
            }

            $result[] = [
                'invoice_header' => $header,
                'line_items' => $lineItems,
            ];
        }

        return $result;
    }

    private function getSportFeeInvoices($studentId)
    {
        $invoices = SportFeeInvoice::where('student_id', $studentId)
            ->with([
                'sport_fee_invoice_item_list',
                'term',
            ])
            ->select(
                'id',
                'student_id',
                'term_id',
                'date',
                'bill_total',
                'discount_total',
                // 'tax_total',
                'subtotal_after_discount',
                'items_total',
                'service_charges_total',
                'subtotal_before_discount',
                'serial_number',
                'is_sport_fee_invoice_complete',
                'sport_fee_invoice_status_id',
                'order_notes',
                'office_notes',
                'created_at'
            )
            ->get()
            ->toArray();

        $result = [];
        foreach ($invoices as $invoice) {
            // Format invoice header
            $header = $this->formatInvoiceHeader($invoice, 'sport_fee_invoice');
            $header['term_info'] = $this->formatTermInfo($invoice['term']);
            $header['amount_breakdown'] = $this->formatAmountBreakdown($invoice);
            $header['status_id'] = $invoice['sport_fee_invoice_status_id'];
            $header['notes'] = [
                'order_notes' => $invoice['order_notes'],
                'office_notes' => $invoice['office_notes'],
            ];

            // Format line items with detailed descriptions and quantities
            $lineItems = [];
            foreach ($invoice['sport_fee_invoice_item_list'] as $item) {
                $lineItems[] = [
                    'id' => $item['id'],
                    'description' => $item['description'] ?? 'Sport Fee Item',
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['qty'],
                    'item_total' => $item['item_total'],
                    'school_fee_id' => $item['school_fee_id'],
                    'is_complete' => $item['is_sport_fee_invoice_item_complete'] ?? false,
                    'category' => 'Sport Fee',
                    'unit_details' => [
                        'price_per_unit' => $item['unit_price'],
                        'units_purchased' => $item['qty'],
                        'total_for_item' => $item['item_total'],
                    ],
                ];
            }

            $result[] = [
                'invoice_header' => $header,
                'line_items' => $lineItems,
            ];
        }

        return $result;
    }

    private function getRefundableDeposits($studentId)
    {
        return RefundableDeposit::where('student_id', $studentId)
            ->with(['refundable_deposit_item_list'])
            ->select(
                'id',
                'student_id',
                'bill_total as refundable_deposit_amount',
                'discount_total as refundable_deposit_discount',
                'service_charges_total as refundable_deposit_tax',
                'subtotal_after_discount as refundable_deposit_net_amount',
                'date as refundable_deposit_date',
                'created_at'
            )
            ->get()
            ->toArray();
    }

    private function getGeneralBills($studentId)
    {
        // GeneralBill table doesn't exist, return empty array for now
        // TODO: Create general_bill table or remove this method if not needed
        return [];
    }

    private function getMaterialBills($studentId)
    {
        return MaterialBill::where('student_id', $studentId)
            ->with(['material_bill_item_list'])
            ->select(
                'id',
                'student_id',
                'bill_total as material_bill_amount',
                'discount_total as material_bill_discount',
                // 'tax_total as material_bill_tax',
                'subtotal_after_discount as material_bill_net_amount',
                'date as material_bill_date',
                'created_at'
            )
            ->get()
            ->toArray();
    }

    private function formatInvoiceHeader($invoice, $type)
    {
        $header = [
            'id' => $invoice['id'],
            'date' => $invoice[strtolower($type).'_date'] ?? $invoice['date'],
            'total_amount' => $invoice[strtolower($type).'_amount'] ?? 0,
            'discount' => $invoice[strtolower($type).'_discount'] ?? 0,
            'tax' => $invoice[strtolower($type).'_tax'] ?? 0,
            'net_amount' => $invoice[strtolower($type).'_net_amount'] ?? 0,
        ];

        // Add serial number if available
        if (isset($invoice['serial_number'])) {
            $header['serial_number'] = $invoice['serial_number'];
        }

        // Add status information
        $statusField = 'is_'.strtolower($type).'_complete';
        if (isset($invoice[$statusField])) {
            $header['status'] = $invoice[$statusField] ? 'complete' : 'incomplete';
        }

        return $header;
    }

    private function formatTermInfo($term)
    {
        if (! $term) {
            return null;
        }

        return [
            'id' => $term['id'],
            'name' => $term['name'],
            'school_year' => $term['school_year'],
            'period' => ($term['start_date'] ?? '').' - '.($term['end_date'] ?? ''),
            'start_date' => $term['start_date'] ?? null,
            'end_date' => $term['end_date'] ?? null,
        ];
    }

    private function formatAmountBreakdown($invoice)
    {
        return [
            'items_total' => $invoice['items_total'] ?? 0,
            'service_charges_total' => $invoice['service_charges_total'] ?? 0,
            'subtotal_before_discount' => $invoice['subtotal_before_discount'] ?? 0,
            'discount_total' => $invoice['discount_total'] ?? 0,
            'subtotal_after_discount' => $invoice['subtotal_after_discount'] ?? 0,
            // 'tax_total' => $invoice['tax_total'] ?? 0,
            'bill_total' => $invoice['bill_total'] ?? 0,
        ];
    }

    private function getStudentInfo($studentId)
    {
        $student = Student::where('id', $studentId)
            ->with(['student_role_list.role_type'])
            ->select('id', 'full_name', 'admission_number')
            ->first();

        if ($student) {
            return [
                'id' => $student->id,
                'full_name' => $student->full_name,
                'admission_number' => $student->admission_number,
                'student_roles' => $this->formatStudentRoles($student->student_role_list),
            ];
        }

        // Return default structure if student not found
        return [
            'id' => $studentId,
            'full_name' => null,
            'admission_number' => null,
            'student_roles' => [],
        ];
    }

    private function formatStudentRoles($roles)
    {
        if (! $roles || $roles->isEmpty()) {
            return [];
        }

        return $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'role_type' => [
                    'id' => $role->role_type->id ?? null,
                    'name' => $role->role_type->name ?? null,
                    'sequential_order' => $role->role_type->sequential_order ?? null,
                ],
                'academic_year' => $role->academic_year,
                'assigned_date' => $role->assigned_date,
                'relieved_date' => $role->relieved_date,
                'remarks' => $role->remarks,
                'is_active' => $role->is_active,
                'status' => $role->is_active ? 'active' : 'inactive',
            ];
        })->toArray();
    }
}
