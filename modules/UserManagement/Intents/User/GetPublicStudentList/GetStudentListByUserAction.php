<?php

namespace Modules\UserManagement\Intents\User\GetPublicStudentList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\UserPaymentStudent;
use Modules\UserManagement\Models\UserPayment;

class GetStudentListByUserAction
{
    use AsAction;

    public function handle(User $user): array
    {
        $data = [
            'student_list' => [],
            'user_payments' => []
        ];

        // 1. Get Student List (Logic from SignInIntent)
        if ($user->user_category == 1) {
            $studentList = [];
            
            $userPaymentStudents = UserPaymentStudent::where('is_active', true)
                ->whereHas('user_payment', function ($paymentQuery) use ($user) {
                    $paymentQuery->where('user_id', $user->id)
                        ->where('is_active', true);
                })
                ->with([
                    'student' => function ($studentQuery) {
                        $studentQuery->select([
                            'id', 'admission_number', 'full_name', 'student_calling_name', 
                            'full_name_with_title', 'gender', 'date_of_birth',
                            'applicant_id', 'student_admission_source_id', 'student_admission_source_other',
                            'joined_date', 'joined_term_id', 'admission_number_digits', 
                            'admission_number_prefix', 'admission_number_current_year',
                            'nationality_id', 'religion_id', 'blood_group', 'special_health_conditions',
                            'grade_level_id', 'grade_level_class_id', 'school_house_id',
                            'school_studied_before', 'special_conditions',
                            'full_address', 'student_address',
                            'phone', 'email', 'student_phone', 'student_email',
                            'admission_fee_discount_percentage', 'approved_admission_fee',
                            'applicable_refundable_deposit', 'applicable_term_payment', 'applicable_year_payment',
                            'has_dropped_out', 'is_sport_list', 'is_school_leaver',
                            'user_id', 'created_by', 'updated_by', 'created_at', 'updated_at',
                            'father_id', 'mother_id', 'guardian_id',
                            'father_full_name', 'father_id_type', 'father_nic_number', 'father_passport_number',
                            'father_phone', 'father_whatsapp', 'father_email', 'father_occupation',
                            'father_place_of_work', 'father_monthly_income',
                            'mother_full_name', 'mother_id_type', 'mother_nic_number', 'mother_passport_number',
                            'mother_phone', 'mother_whatsapp', 'mother_email', 'mother_occupation',
                            'mother_place_of_work', 'mother_monthly_income',
                            'guardian_full_name', 'guardian_id_type', 'guardian_nic_number', 'guardian_passport_number',
                            'guardian_phone', 'guardian_whatsapp', 'guardian_email', 'guardian_occupation',
                            'guardian_place_of_work', 'guardian_monthly_income',
                        ])
                        ->with([
                            'grade_level:id,name',
                            'grade_level_class:id,name',
                            'school_house:id,name',
                            'student_admission_source:id,name',
                            'student_role_list' => function ($roleQuery) {
                                $roleQuery->where('is_active', true)
                                    ->with(['role_type:id,name'])
                                    ->select(['id', 'student_id', 'role_type_id', 'academic_year', 'assigned_date', 'relieved_date', 'is_active']);
                            },
                            'student_achievement_list' => function ($achievementQuery) {
                                $achievementQuery->where('is_active', true)
                                    ->select(['id', 'student_id', 'achievement_type', 'title', 'description', 'start_date', 'end_date', 'is_active', 'created_at', 'updated_at'])
                                    ->orderBy('start_date', 'desc');
                            },
                            'student_sport_list' => function ($sportQuery) {
                                $sportQuery->select(['id', 'student_id', 'sport_id', 'status', 'created_at', 'updated_at'])
                                    ->with(['sport:id,name']);
                            },
                            'student_attachment_list:id,student_id,file_name,original_file_name,mime_type,created_at',
                            'latest_term_fee_receipt_voucher',
                        ]);
                    },
                    'user_payment:id,package_type,start_date,end_date,amount,currency',
                ])
                ->get();

            // Fetch guardian info once outside the loop to avoid N+1 problem
            $studentGuardians = StudentGuardian::where('user_id', $user->id)->get();

            foreach ($userPaymentStudents as $ups) {
                if (!$ups->student) continue;

                $student = $ups->student;
                $guardianInfo = null;

                foreach ($studentGuardians as $guardian) {
                    $relationshipType = '';
                    $guardianTypeText = '';

                    if ($student->father_id == $guardian->id) {
                        $relationshipType = 'father'; $guardianTypeText = 'Father';
                    } elseif ($student->mother_id == $guardian->id) {
                        $relationshipType = 'mother'; $guardianTypeText = 'Mother';
                    } elseif ($student->guardian_id == $guardian->id) {
                        $relationshipType = 'guardian'; $guardianTypeText = 'Guardian';
                    }

                    if ($relationshipType) {
                        $guardianInfo = [
                            'guardian_id' => $guardian->id,
                            'guardian_type' => $guardian->guardian_type,
                            'guardian_type_text' => $guardianTypeText,
                            'relationship_type' => $relationshipType,
                            'guardian_full_name' => $guardian->full_name,
                            'guardian_nic_number' => $guardian->nic_number,
                            'guardian_passport_number' => $guardian->passport_number,
                            'guardian_phone' => $guardian->phone,
                            'guardian_whatsapp' => $guardian->whatsapp,
                            'guardian_email' => $guardian->email,
                            'guardian_occupation' => $guardian->occupation,
                            'guardian_place_of_work' => $guardian->place_of_work,
                            'guardian_monthly_income' => $guardian->monthly_income,
                            'guardian_user_id' => $guardian->user_id,
                        ];
                        break;
                    }
                }

                $studentAttachments = [];
                if ($student->student_attachment_list) {
                    foreach ($student->student_attachment_list as $attachment) {
                        $studentAttachments[] = [
                            'id' => $attachment->id,
                            'file_name' => $attachment->file_name,
                            'original_file_name' => $attachment->original_file_name,
                            'mime_type' => $attachment->mime_type,
                            'created_at' => $attachment->created_at,
                        ];
                    }
                }

                $paymentInfo = [
                    'package_type' => $ups->user_payment->package_type,
                    'access_level' => $ups->access_level,
                    'start_date' => $ups->start_date,
                    'end_date' => $ups->end_date,
                    'payment_amount' => $ups->user_payment->amount,
                    'payment_currency' => $ups->user_payment->currency,
                    'ups_id' => $ups->id,
                    'ups_is_active' => $ups->is_active,
                    'payment_id' => $ups->user_payment->id,
                ];

                $studentRoles = [];
                if ($student->student_role_list) {
                    foreach ($student->student_role_list as $role) {
                        $studentRoles[] = [
                            'id' => $role->id,
                            'role_type_id' => $role->role_type_id,
                            'role_name' => $role->role_type ? $role->role_type->name : null,
                            'academic_year' => $role->academic_year,
                            'assigned_date' => $role->assigned_date,
                            'relieved_date' => $role->relieved_date,
                            'is_active' => $role->is_active,
                        ];
                    }
                }

                $studentAchievements = [];
                if ($student->student_achievement_list) {
                    foreach ($student->student_achievement_list as $achievement) {
                        $studentAchievements[] = [
                            'id' => $achievement->id,
                            'achievement_type' => $achievement->achievement_type,
                            'title' => $achievement->title,
                            'description' => $achievement->description,
                            'start_date' => $achievement->start_date,
                            'end_date' => $achievement->end_date,
                            'is_active' => $achievement->is_active,
                            'created_at' => $achievement->created_at,
                            'updated_at' => $achievement->updated_at,
                        ];
                    }
                }

                $studentSports = [];
                if ($student->student_sport_list) {
                    foreach ($student->student_sport_list as $sport) {
                        $studentSports[] = [
                            'id' => $sport->id,
                            'sport_id' => $sport->sport_id,
                            'sport_name' => $sport->sport ? $sport->sport->name : null,
                            'status' => $sport->status,
                            'created_at' => $sport->created_at,
                            'updated_at' => $sport->updated_at,
                        ];
                    }
                }

                $latestTermFeeReceipt = null;
                if ($student->latest_term_fee_receipt_voucher) {
                    $receipt = $student->latest_term_fee_receipt_voucher;
                    $latestTermFeeReceipt = [
                        'id' => $receipt->id,
                        'student_id' => $receipt->student_id,
                        'admission_fee_settlement' => $receipt->admission_fee_settlement,
                        'refundable_deposit_settlement' => $receipt->refundable_deposit_settlement,
                        'term_fee_settlement' => $receipt->term_fee_settlement,
                    ];
                }

                $studentData = $student->toArray();
                $studentData['guardian_info'] = $guardianInfo;
                $studentData['attachments'] = $studentAttachments;
                $studentData['payment_info'] = $paymentInfo;
                $studentData['student_roles'] = $studentRoles;
                $studentData['student_achievements'] = $studentAchievements;
                $studentData['student_sports'] = $studentSports;
                $studentData['latest_term_fee_receipt'] = $latestTermFeeReceipt;

                $studentList[] = $studentData;
            }
            $data['student_list'] = $studentList;
        }

        // 2. Get User Active Payments
        $data['user_payments'] = $this->getUserActivePayments($user);

        return $data;
    }

    /**
     * Get user's active payments (Logic from SignInIntent)
     */
    private function getUserActivePayments($user)
    {
        try {
            $activePayments = UserPayment::where('user_id', $user->id)
                ->where('is_active', true)
                ->with([
                    'user_payment_students' => function ($query) {
                        $query->where('is_active', true)
                            ->with(['student:id,full_name,admission_number']);
                    },
                ])
                ->select([
                    'id', 'user_id', 'package_type', 'is_active', 'start_date', 'end_date',
                    'amount', 'currency', 'payment_method', 'transaction_reference', 
                    'notes', 'created_at', 'updated_at',
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            $paymentsData = [];
            foreach ($activePayments as $payment) {
                $paymentData = [
                    'id' => $payment->id,
                    'package_type' => $payment->package_type,
                    'package_type_display' => $payment->package_type_display,
                    'is_active' => $payment->is_active,
                    'start_date' => $payment->start_date,
                    'end_date' => $payment->end_date,
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'payment_method' => $payment->payment_method,
                    'transaction_reference' => $payment->transaction_reference,
                    'notes' => $payment->notes,
                    'status' => $payment->status,
                    'is_currently_valid' => $payment->isCurrentlyValid(),
                    'created_at' => $payment->created_at,
                    'updated_at' => $payment->updated_at,
                    'students' => [],
                ];

                foreach ($payment->user_payment_students as $ups) {
                    if ($ups->student) {
                        $paymentData['students'][] = [
                            'id' => $ups->student->id,
                            'full_name' => $ups->student->full_name,
                            'admission_number' => $ups->student->admission_number,
                            'access_level' => $ups->access_level,
                            'ups_start_date' => $ups->start_date,
                            'ups_end_date' => $ups->end_date,
                            'ups_is_active' => $ups->is_active,
                            'ups_status' => $ups->status,
                        ];
                    }
                }
                $paymentsData[] = $paymentData;
            }
            return $paymentsData;
        } catch (\Exception $e) {
            return [];
        }
    }
}
