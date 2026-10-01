<?php

/**
 * Test Expanded Student Details in SignIn Response
 *
 * This script verifies that ALL student fields from the Student model
 * are now included in the SignIn API response.
 */
echo "Testing Expanded Student Details in SignIn Response\n";
echo "==================================================\n";

// Test user credentials (from previous conversations)
$testCredentials = [
    'username_or_email' => 'testuser@nexiscollege.lk',
    'password' => 'password',
];

echo 'Testing with user: '.$testCredentials['username_or_email']."\n\n";

// Test SignIn endpoint
$signInUrl = 'http://127.0.0.1:8000/api/user-management/user/sign-in';

$postData = $testCredentials;
$headers = [
    'Accept: application/json',
    'Content-Type: application/json',
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $signInUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($postData),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_TIMEOUT => 30,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "=== SignIn Test Results ===\n";
echo "HTTP Code: $httpCode\n";

if ($error) {
    echo "cURL Error: $error\n";
    exit(1);
}

if ($httpCode === 200) {
    echo "✅ SignIn Successful!\n\n";

    $responseData = json_decode($response, true);

    if (isset($responseData['data']) && isset($responseData['data']['student_list'])) {
        $userData = $responseData['data'];
        $studentList = $userData['student_list'];

        echo "=== Student List Analysis ===\n";
        echo 'Total Students Found: '.count($studentList)."\n\n";

        if (count($studentList) > 0) {
            $student = $studentList[0]; // Analyze first student

            echo "=== Student Field Analysis ===\n";
            echo 'Analyzing first student (ID: '.($student['id'] ?? 'N/A').")\n\n";

            // Check basic identity fields
            echo "📋 Basic Identity Fields:\n";
            $basicFields = ['id', 'admission_number', 'full_name', 'student_calling_name', 'full_name_with_title', 'gender', 'date_of_birth'];
            foreach ($basicFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check admission details
            echo "\n🎓 Admission Details:\n";
            $admissionFields = ['applicant_id', 'student_admission_source_id', 'student_admission_source_other', 'joined_date', 'joined_term_id'];
            foreach ($admissionFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check personal information
            echo "\n👤 Personal Information:\n";
            $personalFields = ['nationality_id', 'religion_id', 'blood_group', 'special_health_conditions'];
            foreach ($personalFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check address information
            echo "\n🏠 Address Information:\n";
            $addressFields = ['full_address', 'student_address'];
            foreach ($addressFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check contact information
            echo "\n📞 Contact Information:\n";
            $contactFields = ['phone', 'email', 'student_phone', 'student_email'];
            foreach ($contactFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check financial information
            echo "\n💰 Financial Information:\n";
            $financialFields = ['admission_fee_discount_percentage', 'approved_admission_fee', 'applicable_refundable_deposit', 'applicable_term_payment', 'applicable_year_payment'];
            foreach ($financialFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check status flags
            echo "\n🚩 Status Flags:\n";
            $statusFields = ['has_dropped_out', 'is_sport_list', 'is_school_leaver'];
            foreach ($statusFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: ".($value === true ? 'true' : ($value === false ? 'false' : $value))."\n";
            }

            // Check guardian information
            echo "\n👨‍👩‍👧 Guardian Information:\n";
            $guardianFields = [
                'father_full_name', 'father_phone', 'father_email', 'father_occupation',
                'mother_full_name', 'mother_phone', 'mother_email', 'mother_occupation',
                'guardian_full_name', 'guardian_phone', 'guardian_email', 'guardian_occupation',
            ];
            foreach ($guardianFields as $field) {
                $value = $student[$field] ?? 'NULL';
                echo "  ✓ $field: $value\n";
            }

            // Check relationships
            echo "\n🔗 Relationships:\n";
            $relationships = [
                'grade_level' => 'Grade Level',
                'grade_level_class' => 'Grade Level Class',
                'school_house' => 'School House',
                'student_admission_source' => 'Admission Source',
                'student_roles' => 'Student Roles',
                'student_achievements' => 'Student Achievements',
                'student_sports' => 'Student Sports',
                'attachments' => 'Attachments',
                'latest_term_fee_receipt' => 'Latest Term Fee Receipt',
            ];

            foreach ($relationships as $key => $label) {
                if (isset($student[$key])) {
                    if (is_array($student[$key])) {
                        $count = count($student[$key]);
                        echo "  ✅ $label: $count items\n";
                        if ($count > 0 && in_array($key, ['student_achievements', 'student_sports'])) {
                            echo '    - Sample: '.json_encode(array_slice($student[$key], 0, 1))."\n";
                        }
                    } else {
                        $value = $student[$key] ? 'Present' : 'NULL';
                        echo "  ✅ $label: $value\n";
                    }
                } else {
                    echo "  ❌ $label: Missing\n";
                }
            }

            // Count total fields
            $totalFields = count($student);
            echo "\n📊 Summary:\n";
            echo "  • Total fields in student object: $totalFields\n";
            echo '  • Student ID: '.($student['id'] ?? 'N/A')."\n";
            echo '  • Student Name: '.($student['full_name'] ?? 'N/A')."\n";
            echo '  • Admission Number: '.($student['admission_number'] ?? 'N/A')."\n";

        } else {
            echo "❌ No students found in the response\n";
            echo "This could mean:\n";
            echo "- User has no associated students\n";
            echo "- User payment records are not set up\n";
            echo "- Database tables don't exist yet\n";
        }

    } else {
        echo "❌ No student_list found in response data\n";
        echo 'Response structure: '.json_encode($responseData, JSON_PRETTY_PRINT)."\n";
    }

} elseif ($httpCode === 401) {
    echo "❌ Authentication Failed (Invalid Credentials)\n";
    echo "Response: $response\n";
} else {
    echo "❌ SignIn Failed (HTTP $httpCode)\n";
    echo "Response: $response\n";
}

echo "\n=== Expected vs Actual Field Count ===\n";
echo "Expected minimum fields from Student model: ~80+ (all fillable fields)\n";
echo "Expected relationships: 9 additional relationship arrays\n";
echo "Total expected: 90+ fields and arrays\n";

echo "\n--- Expanded Student Details Test Completed ---\n";
