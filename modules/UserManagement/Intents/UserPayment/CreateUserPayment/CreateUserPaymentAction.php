<?php

namespace Modules\UserManagement\Intents\UserPayment\CreateUserPayment;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserPayment;
use Modules\UserManagement\Models\UserPaymentStudent;

class CreateUserPaymentAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $validatedData = CreateUserPaymentUserDTO::validate($payloadArray);

        return DB::transaction(function () use ($validatedData, $actionData) {
            // 1. Validate that user exists
            $user = User::find($validatedData['user_id']);
            if (!$user) {
                throw new \Exception("User with ID {$validatedData['user_id']} not found");
            }

            // 2. Validate that all students exist
            $students = Student::whereIn('id', $validatedData['student_ids'])->get();
            if ($students->count() !== count($validatedData['student_ids'])) {
                throw new \Exception("One or more student IDs are invalid");
            }

            // 3. Validate package type limits
            $this->validatePackageLimits($validatedData['package_type'], count($validatedData['student_ids']));

            // 4. Create the UserPayment record
            $userPayment = UserPayment::create([
                'user_id' => $validatedData['user_id'],
                'package_type' => $validatedData['package_type'],
                'is_active' => $validatedData['is_active'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'amount' => $validatedData['amount'],
                'currency' => $validatedData['currency'],
                'payment_method' => $validatedData['payment_method'],
                'transaction_reference' => $validatedData['transaction_reference'],
                'notes' => $validatedData['notes'],
                'created_by' => $actionData['user_id'] ?? null,
            ]);

            // 5. Create UserPaymentStudent records for each student
            $userPaymentStudents = [];
            foreach ($validatedData['student_ids'] as $studentId) {
                $userPaymentStudent = UserPaymentStudent::create([
                    'user_payment_id' => $userPayment->id,
                    'student_id' => $studentId,
                    'is_active' => $validatedData['is_active'],
                    'start_date' => $validatedData['start_date'],
                    'end_date' => $validatedData['end_date'],
                    'access_level' => $validatedData['access_level'],
                    'notes' => "Student linked to {$validatedData['package_type']} package",
                    'created_by' => $actionData['user_id'] ?? null,
                ]);
                
                $userPaymentStudents[] = $userPaymentStudent;
            }

            // 6. Load relationships for response
            $userPayment->load([
                'user:id,full_name,username,email',
                'user_payment_students.student:id,full_name,admission_number,grade_level_id',
                'user_payment_students.student.grade_level:id,name',
                'created_by_user:id,call_name_with_title'
            ]);

            return [
                'payment' => $userPayment,
                'student_count' => count($userPaymentStudents),
                'package_type_display' => $userPayment->package_type_display,
                'status' => $userPayment->status,
                'message' => "Payment created successfully with {$userPayment->package_type} package for " . count($userPaymentStudents) . " student(s)"
            ];
        });
    }

    private function validatePackageLimits($packageType, $studentCount)
    {
        $limits = [
            'basic' => 1,
            'family' => 5,
            'premium' => 10,
            'annual' => 999, // Unlimited for annual
        ];

        $limit = $limits[$packageType] ?? 1;
        
        if ($studentCount > $limit) {
            throw new \Exception("The {$packageType} package allows a maximum of {$limit} student(s). You selected {$studentCount} student(s).");
        }
    }
}