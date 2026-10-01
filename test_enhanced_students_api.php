<?php

require_once 'vendor/autoload.php';

use Modules\StudentManagement\Intents\Student\GetStudentsByClass\GetStudentsByClassAction;

// Test the enhanced API action directly
try {
    echo "Testing Enhanced get-students-by-class API\n";
    echo "=========================================\n\n";

    $payloadArray = ['grade_level_class_id' => 1];
    $actionData = ['user_id' => 1, 'username' => 'testuser'];

    $result = GetStudentsByClassAction::run($payloadArray, $actionData);

    echo "SUCCESS: API executed successfully\n";
    echo "Total students found: " . $result->total . "\n\n";

    if ($result->total > 0) {
        $firstStudent = $result->data[0];
        
        echo "Sample Student Data Fields:\n";
        echo "---------------------------\n";
        
        // Display core student fields
        echo "Basic Info:\n";
        echo "- ID: " . ($firstStudent['id'] ?? 'null') . "\n";
        echo "- Admission Number: " . ($firstStudent['admission_number'] ?? 'null') . "\n";
        echo "- Full Name: " . ($firstStudent['full_name'] ?? 'null') . "\n";
        echo "- Full Name with Title: " . ($firstStudent['full_name_with_title'] ?? 'null') . "\n";
        echo "- Gender: " . ($firstStudent['gender'] ?? 'null') . "\n";
        echo "- Date of Birth: " . ($firstStudent['date_of_birth'] ?? 'null') . "\n";
        echo "- Blood Group: " . ($firstStudent['blood_group'] ?? 'null') . "\n";
        echo "- Calling Name: " . ($firstStudent['student_calling_name'] ?? 'null') . "\n\n";

        echo "Contact Info:\n";
        echo "- Email: " . ($firstStudent['email'] ?? 'null') . "\n";
        echo "- Phone: " . ($firstStudent['phone'] ?? 'null') . "\n";
        echo "- Student Phone: " . ($firstStudent['student_phone'] ?? 'null') . "\n";
        echo "- Student Email: " . ($firstStudent['student_email'] ?? 'null') . "\n";
        echo "- Address: " . ($firstStudent['full_address'] ?? 'null') . "\n";
        echo "- Student Address: " . ($firstStudent['student_address'] ?? 'null') . "\n\n";

        echo "Academic Info:\n";
        echo "- Grade Level Class ID: " . ($firstStudent['grade_level_class_id'] ?? 'null') . "\n";
        echo "- Grade Level ID: " . ($firstStudent['grade_level_id'] ?? 'null') . "\n";
        echo "- School House ID: " . ($firstStudent['school_house_id'] ?? 'null') . "\n";
        echo "- Joined Date: " . ($firstStudent['joined_date'] ?? 'null') . "\n";
        echo "- Is Sport List: " . ($firstStudent['is_sport_list'] ? 'Yes' : 'No') . "\n";
        echo "- Has Dropped Out: " . ($firstStudent['has_dropped_out'] ? 'Yes' : 'No') . "\n";
        echo "- Is School Leaver: " . ($firstStudent['is_school_leaver'] ? 'Yes' : 'No') . "\n\n";

        echo "Guardian Info:\n";
        echo "- Father Name: " . ($firstStudent['father_full_name'] ?? 'null') . "\n";
        echo "- Father Phone: " . ($firstStudent['father_phone'] ?? 'null') . "\n";
        echo "- Father Email: " . ($firstStudent['father_email'] ?? 'null') . "\n";
        echo "- Mother Name: " . ($firstStudent['mother_full_name'] ?? 'null') . "\n";
        echo "- Mother Phone: " . ($firstStudent['mother_phone'] ?? 'null') . "\n";
        echo "- Mother Email: " . ($firstStudent['mother_email'] ?? 'null') . "\n";
        echo "- Guardian Name: " . ($firstStudent['guardian_full_name'] ?? 'null') . "\n\n";

        echo "Financial Info:\n";
        echo "- Approved Admission Fee: " . ($firstStudent['approved_admission_fee'] ?? 'null') . "\n";
        echo "- Admission Fee Discount %: " . ($firstStudent['admission_fee_discount_percentage'] ?? 'null') . "\n";
        echo "- Applicable Term Payment: " . ($firstStudent['applicable_term_payment'] ?? 'null') . "\n";
        echo "- Applicable Year Payment: " . ($firstStudent['applicable_year_payment'] ?? 'null') . "\n\n";

        echo "Loaded Relationships:\n";
        echo "---------------------\n";
        
        // Check which relationships were loaded
        $relationships = [
            'grade_level_class',
            'grade_level', 
            'school_house',
            'nationality',
            'religion',
            'student_admission_source',
            'father',
            'mother', 
            'guardian',
            'student_achievement_list',
            'student_role_list',
            'student_sport_list',
            'student_attendance_list',
            'latest_term_fee_receipt_voucher',
            'current_user_payment_students',
            'student_supply_list',
            'student_attachment_list',
        ];

        foreach ($relationships as $rel) {
            $isLoaded = isset($firstStudent[$rel]);
            $count = '';
            if ($isLoaded && is_array($firstStudent[$rel])) {
                $count = ' (' . count($firstStudent[$rel]) . ' records)';
            } elseif ($isLoaded && is_object($firstStudent[$rel])) {
                $count = ' (object loaded)';
            } elseif ($isLoaded && !is_null($firstStudent[$rel])) {
                $count = ' (data loaded)';
            }
            echo "- " . $rel . ": " . ($isLoaded ? "✓ Loaded" . $count : "✗ Not loaded") . "\n";
        }

        echo "\nTotal fields in response: " . count($firstStudent) . "\n";
        echo "All available fields: " . implode(', ', array_keys($firstStudent)) . "\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}