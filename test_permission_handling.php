<?php

/**
 * Test permission handling with non-writable directory
 */

// Create a test image
$width = 200;
$height = 150;
$image = imagecreatetruecolor($width, $height);
$blue = imagecolorallocate($image, 0, 100, 200);
$white = imagecolorallocate($image, 255, 255, 255);

imagefill($image, 0, 0, $blue);
imagestring($image, 5, 50, 70, 'PERMISSION TEST', $white);

$tempFile = tempnam(sys_get_temp_dir(), 'perm_test_').'.jpg';
imagejpeg($image, $tempFile, 90);
imagedestroy($image);

echo "Created test image: $tempFile\n";
echo 'File size: '.filesize($tempFile)." bytes\n\n";

// Test debug endpoint to see permission handling
$url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';

$postData = [
    'profile_image' => new CURLFile($tempFile, 'image/jpeg', 'permission-test.jpg'),
];

$headers = ['Accept: application/json'];

echo "=== Testing Permission Handling ===\n";

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
    echo "✅ SUCCESS - Permission handling worked!\n";
    $responseData = json_decode($response, true);
    if (isset($responseData['data']['file_path'])) {
        echo 'File Path: '.$responseData['data']['file_path']."\n";

        // Check if it used temp directory
        if (strpos($responseData['data']['file_path'], 'temp-uploads') !== false) {
            echo "✅ Fallback temp directory was used successfully!\n";
        }
    }
} else {
    echo "Response: $response\n";
}

// Clean up
unlink($tempFile);

echo "\n--- Permission Test Completed ---\n";
