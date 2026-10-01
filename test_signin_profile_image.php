<?php

/**
 * Test SignIn endpoint to verify profile image inclusion
 */
echo "Testing SignIn Endpoint with Profile Image\n";
echo "==========================================\n";

// Test user credentials (adjusted to match database)
$testCredentials = [
    'username_or_email' => 'testuser@nexiscollege.lk', // Try with email
    'password' => 'password', // Default Laravel password hash
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

    if (isset($responseData['data'])) {
        $userData = $responseData['data'];

        echo "=== User Information ===\n";
        echo 'ID: '.$userData['id']."\n";
        echo 'Name: '.$userData['full_name']."\n";
        echo 'Email: '.$userData['email']."\n";
        echo 'Category: '.$userData['user_category']."\n";

        echo "\n=== Profile Image Analysis ===\n";

        if (isset($userData['profile_image']) && $userData['profile_image'] !== null) {
            $profileImage = $userData['profile_image'];

            echo "✅ Profile Image Found!\n";
            echo '- Image ID: '.$profileImage['id']."\n";
            echo '- Filename: '.$profileImage['filename']."\n";
            echo '- Format: '.$profileImage['file_format'].' ('.$profileImage['mime_type'].")\n";
            echo '- Size: '.$profileImage['file_size_formatted'].' ('.number_format($profileImage['file_size'])." bytes)\n";
            echo '- Dimensions: '.$profileImage['dimensions_string']."\n";
            echo '- Full URL: '.$profileImage['full_url']."\n";
            echo '- Public Path: '.$profileImage['public_path']."\n";
            echo '- Created: '.$profileImage['created_at']."\n";
            echo '- Updated: '.$profileImage['updated_at']."\n";

            // Check if the target size range was achieved (200KB-500KB)
            $sizeKB = round($profileImage['file_size'] / 1024, 1);
            $targetMin = 200;
            $targetMax = 500;
            $inTargetRange = ($sizeKB >= $targetMin && $sizeKB <= $targetMax);

            echo "\n=== Compression Analysis ===\n";
            echo "- Size: {$sizeKB}KB\n";
            echo "- Target Range: {$targetMin}KB - {$targetMax}KB\n";
            echo '- Target Achieved: '.($inTargetRange ? '✅ YES' : '❌ NO')."\n";

            if (! $inTargetRange) {
                if ($sizeKB < $targetMin) {
                    echo '- Status: Below target (need '.round($targetMin - $sizeKB, 1)."KB more)\n";
                } else {
                    echo '- Status: Above target (need '.round($sizeKB - $targetMax, 1)."KB less)\n";
                }
            }

        } else {
            echo "❌ No Profile Image Found\n";
            echo "- This user doesn't have an active profile image\n";
            echo "- Upload a profile image first to test\n";
        }

        echo "\n=== Other Data Present ===\n";
        echo '- User Type List: '.(isset($userData['user_type_list']) ? 'Yes' : 'No')."\n";
        echo '- Student List: '.(isset($userData['student_list']) ? 'Yes ('.count($userData['student_list']).' students)' : 'No')."\n";
        echo '- User Payments: '.(isset($userData['user_payments']) ? 'Yes ('.count($userData['user_payments']).' payments)' : 'No')."\n";

    } else {
        echo "❌ No user data in response\n";
        echo "Response: $response\n";
    }

} elseif ($httpCode === 401) {
    echo "❌ Authentication Failed (Invalid Credentials)\n";
    echo "Response: $response\n";
} else {
    echo "❌ SignIn Failed\n";
    echo "Response: $response\n";
}

echo "\n--- SignIn Profile Image Test Completed ---\n";
