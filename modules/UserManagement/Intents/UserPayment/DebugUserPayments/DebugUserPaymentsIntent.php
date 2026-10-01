<?php

namespace Modules\UserManagement\Intents\UserPayment\DebugUserPayments;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserPayment;
use Modules\UserManagement\Models\UserPaymentStudent;

class DebugUserPaymentsIntent
{
    use AsController;

    public function asController(Request $request): JsonResponse
    {
        try {
            $userId = $request->input('user_id');
            $debug = [];

            // Basic counts
            $debug['basic_counts'] = [
                'total_users' => User::count(),
                'total_payments' => UserPayment::count(),
                'active_payments' => UserPayment::where('is_active', true)->count(),
                'total_payment_students' => UserPaymentStudent::count(),
                'active_payment_students' => UserPaymentStudent::where('is_active', true)->count(),
                'total_students' => Student::count(),
            ];

            // If user_id provided, get specific user data
            if ($userId) {
                $user = User::find($userId);
                if (! $user) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not found',
                        'data' => null,
                    ], 404);
                }

                $debug['user_info'] = [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'username' => $user->username,
                    'user_category' => $user->user_category,
                ];

                // Get user's payments with relationships
                $userPayments = UserPayment::where('user_id', $userId)
                    ->with(['user_payment_students.student'])
                    ->get();

                $debug['user_payments'] = [];
                foreach ($userPayments as $payment) {
                    $paymentData = [
                        'payment_id' => $payment->id,
                        'package_type' => $payment->package_type,
                        'is_active' => $payment->is_active,
                        'start_date' => $payment->start_date,
                        'end_date' => $payment->end_date,
                        'amount' => $payment->amount,
                        'currency' => $payment->currency,
                        'is_currently_valid' => $payment->isCurrentlyValid(),
                        'status' => $payment->status,
                        'students' => [],
                    ];

                    foreach ($payment->user_payment_students as $ups) {
                        $studentData = [
                            'ups_id' => $ups->id,
                            'student_id' => $ups->student_id,
                            'ups_is_active' => $ups->is_active,
                            'ups_start_date' => $ups->start_date,
                            'ups_end_date' => $ups->end_date,
                            'access_level' => $ups->access_level,
                            'ups_is_currently_valid' => $ups->isCurrentlyValid(),
                            'ups_status' => $ups->status,
                        ];

                        if ($ups->student) {
                            $studentData['student_info'] = [
                                'id' => $ups->student->id,
                                'full_name' => $ups->student->full_name,
                                'admission_number' => $ups->student->admission_number,
                            ];
                        } else {
                            $studentData['student_info'] = 'STUDENT NOT FOUND - BROKEN RELATIONSHIP';
                        }

                        $paymentData['students'][] = $studentData;
                    }

                    $debug['user_payments'][] = $paymentData;
                }

                // Test the current SignIn query logic
                $debug['signin_query_test'] = $this->testSignInQuery($user);

                // Test the new SignIn user payments feature
                $debug['signin_user_payments_test'] = $this->testSignInUserPayments($user);
            }

            // Get all payments for overview
            $debug['all_payments_overview'] = UserPayment::with(['user:id,full_name,username', 'user_payment_students'])
                ->select('id', 'user_id', 'package_type', 'is_active', 'start_date', 'end_date')
                ->get()
                ->map(function ($payment) {
                    return [
                        'payment_id' => $payment->id,
                        'user' => $payment->user ? $payment->user->full_name.' ('.$payment->user->username.')' : 'USER NOT FOUND',
                        'package_type' => $payment->package_type,
                        'is_active' => $payment->is_active,
                        'start_date' => $payment->start_date,
                        'end_date' => $payment->end_date,
                        'student_count' => $payment->user_payment_students->count(),
                        'active_student_count' => $payment->user_payment_students->where('is_active', true)->count(),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'message' => 'Debug data retrieved',
                'data' => $debug,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Debug failed: '.$e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    private function testSignInQuery($user)
    {
        try {
            // Test the exact query from SignIn
            $accessibleStudents = Student::whereHas('user_payment_students', function ($query) use ($user) {
                $query->where('is_active', true)
                    ->where('start_date', '<=', now()->toDateString())
                    ->where(function ($dateQuery) {
                        $dateQuery->where('end_date', '>=', now()->toDateString())
                            ->orWhereNull('end_date');
                    })
                    ->whereHas('user_payment', function ($paymentQuery) use ($user) {
                        $paymentQuery->where('user_id', $user->id)
                            ->where('is_active', true)
                            ->where('start_date', '<=', now()->toDateString())
                            ->where(function ($paymentDateQuery) {
                                $paymentDateQuery->where('end_date', '>=', now()->toDateString())
                                    ->orWhereNull('end_date');
                            });
                    });
            })
                ->select('id', 'full_name', 'admission_number')
                ->get();

            return [
                'query_executed' => true,
                'students_found' => $accessibleStudents->count(),
                'students' => $accessibleStudents->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'full_name' => $student->full_name,
                        'admission_number' => $student->admission_number,
                    ];
                })->toArray(),
            ];

        } catch (\Exception $e) {
            return [
                'query_executed' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    private function testSignInUserPayments($user)
    {
        try {
            // Test the new getUserActivePayments functionality from SignIn
            $activePayments = UserPayment::where('user_id', $user->id)
                ->where('is_active', true)
                ->with([
                    'user_payment_students' => function ($query) {
                        $query->where('is_active', true)
                            ->with(['student:id,full_name,admission_number']);
                    },
                ])
                ->get();

            $paymentsData = [];
            foreach ($activePayments as $payment) {
                $studentsInfo = [];
                foreach ($payment->user_payment_students as $ups) {
                    if ($ups->student) {
                        $studentsInfo[] = [
                            'student_id' => $ups->student->id,
                            'student_name' => $ups->student->full_name,
                            'access_level' => $ups->access_level,
                            'ups_is_active' => $ups->is_active,
                        ];
                    }
                }

                $paymentsData[] = [
                    'payment_id' => $payment->id,
                    'package_type' => $payment->package_type,
                    'status' => $payment->status,
                    'is_currently_valid' => $payment->isCurrentlyValid(),
                    'student_count' => count($studentsInfo),
                    'students' => $studentsInfo,
                ];
            }

            return [
                'query_executed' => true,
                'active_payments_found' => count($paymentsData),
                'payments_detail' => $paymentsData,
            ];

        } catch (\Exception $e) {
            return [
                'query_executed' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
