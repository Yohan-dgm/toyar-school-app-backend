<?php

namespace Modules\UserManagement\Intents\User\SignIn;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentAttachment;
use Modules\UserManagement\Models\UserPayment;
use Modules\UserManagement\Models\UserPaymentStudent;

class SignInIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        try {
            // 1. Authorization

            // 2. User Data Validation
            $signInUserDTO = SignInUserDTO::validate($request->all());

            // 3. Before Intent

            // 4. Business Rules Validation

            // Action 1
            $actionData = [];
            $signInResult = SignInAction::run($signInUserDTO, $actionData, $request);

            // After Intent

            // Return Response
            if ($signInResult) {
                $data['token'] = $signInResult;
                
                // Load user with profile image relationship for optimal performance
                $user = $request->user()->load(['profile_images' => function ($query) {
                    $query->active()->orderedByDate()->limit(1);
                }]);
                
                $data['id'] = $user->id;
                $data['full_name'] = $user->full_name;
                $data['username'] = $user->username;
                $data['email'] = $user->email;
                $data['user_category'] = $user->user_category;
                $data['user_type_list'] = $user->user_type_list->select('name', 'pivot');
                
                // Add latest profile image data
                $profileImage = $user->getActiveProfileImage();
                $data['profile_image'] = $profileImage ? [
                    'id' => $profileImage->id,
                    'file_path' => $profileImage->file_path,
                    'filename' => $profileImage->filename,
                    'file_format' => $profileImage->file_format,
                    'file_size' => $profileImage->file_size,
                    'file_size_formatted' => $profileImage->getFormattedSize(),
                    'mime_type' => $profileImage->mime_type,
                    'width' => $profileImage->width,
                    'height' => $profileImage->height,
                    'dimensions_string' => $profileImage->getDimensionsString(),
                    'full_url' => $profileImage->getFullUrl(),
                    'public_path' => $profileImage->getPublicPath(),
                    'created_at' => $profileImage->created_at,
                    'updated_at' => $profileImage->updated_at,
                ] : null;
                
                // Log profile image inclusion for debugging and analytics
                \Log::info('SignIn Profile Image', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'has_profile_image' => $profileImage !== null,
                    'profile_image_id' => $profileImage?->id,
                    'image_size' => $profileImage ? $profileImage->getFormattedSize() : null,
                    'image_dimensions' => $profileImage ? $profileImage->getDimensionsString() : null,
                    'image_created_at' => $profileImage?->created_at,
                ]);

                // If user_category is 1 (guardian), get related students directly from user_payment_student records
                if ($user->user_category == 1) {
                    $studentList = [];
                    $currentDate = now()->toDateString();

                    // Direct approach: Get user_payment_students with full relationships
                    // This explicitly checks:
                    // - user_payment_student.is_active = true
                    // - user_payment_student.student_id exists (via student relationship)
                    // - Related user_payment belongs to current user and is active
                    // - Date validation for payment periods
                    // Simplified approach: Match the user_payments query logic exactly
                    $userPaymentStudents = UserPaymentStudent::where('is_active', true)
                        ->whereHas('user_payment', function ($paymentQuery) use ($user) {
                            $paymentQuery->where('user_id', $user->id)
                                ->where('is_active', true);
                        })
                        ->with([
                            'student' => function ($studentQuery) {
                                $studentQuery->select([
                                    // Basic Identity
                                    'id',
                                    'admission_number',
                                    'full_name',
                                    'student_calling_name',
                                    'full_name_with_title',
                                    'gender',
                                    'date_of_birth',
                                    
                                    // Admission Details
                                    'applicant_id',
                                    'student_admission_source_id',
                                    'student_admission_source_other',
                                    'joined_date',
                                    'joined_term_id',
                                    'admission_number_digits',
                                    'admission_number_prefix',
                                    'admission_number_current_year',
                                    
                                    // Personal Information
                                    'nationality_id',
                                    'religion_id',
                                    'blood_group',
                                    'special_health_conditions',
                                    
                                    // Academic Information
                                    'grade_level_id',
                                    'grade_level_class_id',
                                    'school_house_id',
                                    'school_studied_before',
                                    'special_conditions',
                                    
                                    // Address Information
                                    'full_address',
                                    'student_address',
                                    
                                    // Contact Information
                                    'phone',
                                    'email',
                                    'student_phone',
                                    'student_email',
                                    
                                    // Financial Information
                                    'admission_fee_discount_percentage',
                                    'approved_admission_fee',
                                    'applicable_refundable_deposit',
                                    'applicable_term_payment',
                                    'applicable_year_payment',
                                    
                                    // Status Flags
                                    'has_dropped_out',
                                    'is_sport_list',
                                    'is_school_leaver',
                                    
                                    // System Information
                                    'user_id',
                                    'created_by',
                                    'updated_by',
                                    'created_at',
                                    'updated_at',
                                    
                                    // Guardian Relationship References
                                    'father_id',
                                    'mother_id',
                                    'guardian_id',
                                    
                                    // Father Information
                                    'father_full_name',
                                    'father_id_type',
                                    'father_nic_number',
                                    'father_passport_number',
                                    'father_phone',
                                    'father_whatsapp',
                                    'father_email',
                                    'father_occupation',
                                    'father_place_of_work',
                                    'father_monthly_income',
                                    
                                    // Mother Information
                                    'mother_full_name',
                                    'mother_id_type',
                                    'mother_nic_number',
                                    'mother_passport_number',
                                    'mother_phone',
                                    'mother_whatsapp',
                                    'mother_email',
                                    'mother_occupation',
                                    'mother_place_of_work',
                                    'mother_monthly_income',
                                    
                                    // Guardian Information
                                    'guardian_full_name',
                                    'guardian_id_type',
                                    'guardian_nic_number',
                                    'guardian_passport_number',
                                    'guardian_phone',
                                    'guardian_whatsapp',
                                    'guardian_email',
                                    'guardian_occupation',
                                    'guardian_place_of_work',
                                    'guardian_monthly_income',
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

                    // Debug logging for direct approach
                    \Log::info('SignIn Payment Debug - Simplified Direct Approach', [
                        'user_id' => $user->id,
                        'user_category' => $user->user_category,
                        'user_payment_students_found' => $userPaymentStudents->count(),
                        'student_ids' => $userPaymentStudents->whereNotNull('student')->pluck('student.id')->toArray(),
                        'query_logic' => 'Simplified to match user_payments query (no complex date filtering)',
                    ]);

                    foreach ($userPaymentStudents as $ups) {
                        // Skip if student doesn't exist (broken relationship)
                        if (! $ups->student) {
                            \Log::warning('SignIn Payment Warning: UserPaymentStudent has no valid student', [
                                'user_id' => $user->id,
                                'ups_id' => $ups->id,
                                'student_id' => $ups->student_id,
                            ]);

                            continue;
                        }

                        $student = $ups->student;

                        // Get guardian information (fallback to existing logic if needed)
                        $guardianInfo = null;
                        $studentGuardians = StudentGuardian::where('user_id', $user->id)->get();

                        foreach ($studentGuardians as $guardian) {
                            $relationshipType = '';
                            $guardianTypeText = '';

                            if ($student->father_id == $guardian->id) {
                                $relationshipType = 'father';
                                $guardianTypeText = 'Father';
                            } elseif ($student->mother_id == $guardian->id) {
                                $relationshipType = 'mother';
                                $guardianTypeText = 'Mother';
                            } elseif ($student->guardian_id == $guardian->id) {
                                $relationshipType = 'guardian';
                                $guardianTypeText = 'Guardian';
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

                        // Get student attachments (use eager-loaded relationship)
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

                        // Get payment information directly from the user_payment_student record
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

                        // Get student roles
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

                        // Get student achievements
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

                        // Get student sports
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

                        // Get latest term fee receipt voucher
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

                        // Build student data
                        $studentData = $student->toArray();
                        $studentData['guardian_info'] = $guardianInfo;
                        $studentData['attachments'] = $studentAttachments;
                        $studentData['payment_info'] = $paymentInfo;
                        $studentData['student_roles'] = $studentRoles;
                        $studentData['student_achievements'] = $studentAchievements;
                        $studentData['student_sports'] = $studentSports;
                        $studentData['latest_term_fee_receipt'] = $latestTermFeeReceipt;

                        // Log successful student inclusion
                        \Log::info('SignIn Payment Success: Student included in list', [
                            'user_id' => $user->id,
                            'student_id' => $student->id,
                            'student_name' => $student->full_name,
                            'student_admission_number' => $student->admission_number,
                            'payment_package_type' => $paymentInfo['package_type'] ?? 'unknown',
                            'payment_access_level' => $paymentInfo['access_level'] ?? 'unknown',
                            'student_roles_count' => count($studentRoles),
                            'student_role_names' => array_filter(array_column($studentRoles, 'role_name')),
                            'student_achievements_count' => count($studentAchievements),
                            'achievement_titles' => array_filter(array_column($studentAchievements, 'title')),
                            'student_sports_count' => count($studentSports),
                            'sport_names' => array_filter(array_column($studentSports, 'sport_name')),
                            'attachments_count' => count($studentAttachments),
                            'has_term_fee_receipt' => $latestTermFeeReceipt !== null,
                        ]);

                        $studentList[] = $studentData;
                    }

                    // Final summary log
                    \Log::info('SignIn Payment Final Summary', [
                        'user_id' => $user->id,
                        'user_category' => $user->user_category,
                        'total_user_payment_students_found' => $userPaymentStudents->count(),
                        'valid_students_processed' => $userPaymentStudents->whereNotNull('student')->count(),
                        'final_student_list_count' => count($studentList),
                        'final_student_ids' => array_map(function ($s) {
                            return $s['id'];
                        }, $studentList),
                    ]);

                    $data['student_list'] = $studentList;
                } else {
                    $data['student_list'] = [];
                }

                // Add user's active payments information for all users
                $userPayments = $this->getUserActivePayments($user);
                $data['user_payments'] = $userPayments;

                return $data;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            if ($result) {
                return response()->json(
                    [
                        'status' => 'successful',
                        'message' => '',
                        'data' => $result,
                        'metadata' => null,
                    ],
                    200
                );
            } else {
                return response()->json([
                    'status' => 'invalid-credentials',
                    'message' => '',
                    'data' => null,
                    'metadata' => null,
                ], 401);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get user's active payments with comprehensive details and relationships
     */
    private function getUserActivePayments($user)
    {
        try {
            // Query user's active payments with relationships
            $activePayments = UserPayment::where('user_id', $user->id)
                ->where('is_active', true)
                ->with([
                    'user_payment_students' => function ($query) {
                        $query->where('is_active', true)
                            ->with(['student:id,full_name,admission_number']);
                    },
                ])
                ->select([
                    'id',
                    'user_id',
                    'package_type',
                    'is_active',
                    'start_date',
                    'end_date',
                    'amount',
                    'currency',
                    'payment_method',
                    'transaction_reference',
                    'notes',
                    'created_at',
                    'updated_at',
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            // Transform payments to include computed fields
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

                // Add students linked to this payment
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

            // Log user payments information
            \Log::info('SignIn User Payments Loaded', [
                'user_id' => $user->id,
                'active_payments_count' => count($paymentsData),
                'payment_ids' => array_column($paymentsData, 'id'),
                'total_students_across_payments' => array_sum(array_map(function ($p) {
                    return count($p['students']);
                }, $paymentsData)),
            ]);

            return $paymentsData;

        } catch (\Exception $e) {
            \Log::error('SignIn User Payments Error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }
}
