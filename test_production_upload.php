<?php

/**
 * Test production upload endpoint to simulate Postman behavior
 */

// Create a test image
$width = 300;
$height = 250;
$image = imagecreatetruecolor($width, $height);
$orange = imagecolorallocate($image, 255, 165, 0);
$black = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $orange);
imagestring($image, 5, 80, 120, 'PRODUCTION TEST', $black);

$tempFile = tempnam(sys_get_temp_dir(), 'prod_test_').'.jpg';
imagejpeg($image, $tempFile, 90);
imagedestroy($image);

echo "Created test image: $tempFile\n";
echo 'File size: '.filesize($tempFile)." bytes\n\n";

// Test both debug and production endpoints
$endpoints = [
    'DEBUG' => 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo',
    'PRODUCTION' => 'http://127.0.0.1:8000/api/user-management/user-profile/upload-profile-photo',
];

foreach ($endpoints as $type => $url) {
    echo "=== Testing $type endpoint ===\n";

    $postData = [
        'profile_image' => new CURLFile($tempFile, 'image/jpeg', 'production-test.jpg'),
    ];

    $headers = ['Accept: application/json'];

    if ($type === 'PRODUCTION') {
        // Add authentication headers for production endpoint
        $headers[] = 'Authorization: Bearer 1|test-token';
        $headers[] = 'Cookie: t_session=test-session-cookie';
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    echo "HTTP Code: $httpCode\n";

    if ($error) {
        echo "cURL Error: $error\n";
    }

    if ($httpCode === 201) {
        echo "✅ SUCCESS!\n";
        $responseData = json_decode($response, true);
        if (isset($responseData['data']['file_path'])) {
            echo 'File Path: '.$responseData['data']['file_path']."\n";
        }
    } else {
        echo "❌ Response: $response\n";
    }
    echo "\n";
}

// Clean up
unlink($tempFile);

echo "--- Production Test Completed ---\n";
