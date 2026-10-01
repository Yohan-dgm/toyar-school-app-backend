<?php

/**
 * Test image compression with smaller, simpler image
 */

// Create a smaller test image that definitely meets validation criteria
$width = 400;
$height = 300;
$image = imagecreatetruecolor($width, $height);

// Simple gradient
$red = imagecolorallocate($image, 255, 100, 100);
$blue = imagecolorallocate($image, 100, 100, 255);
$white = imagecolorallocate($image, 255, 255, 255);

// Fill with gradient
for ($x = 0; $x < $width; $x++) {
    $ratio = $x / $width;
    $r = (int) (255 * $ratio + 100 * (1 - $ratio));
    $g = 100;
    $b = (int) (255 * (1 - $ratio) + 100 * $ratio);
    $color = imagecolorallocate($image, $r, $g, $b);
    imageline($image, $x, 0, $x, $height, $color);
}

// Add text
imagestring($image, 5, 120, 140, 'SIMPLE COMPRESS', $white);

$tempFile = tempnam(sys_get_temp_dir(), 'simple_test_').'.jpg';
imagejpeg($image, $tempFile, 90); // Save as JPEG
imagedestroy($image);

echo "Created simple test image: $tempFile\n";
echo 'File size: '.number_format(filesize($tempFile))." bytes\n";
echo "Dimensions: {$width}x{$height}\n\n";

// Test with debug endpoint
$url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';

$postData = [
    'profile_image' => new CURLFile($tempFile, 'image/jpeg', 'simple-test.jpg'),
];

$headers = ['Accept: application/json'];

echo "=== Testing Simple Image Compression ===\n";

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

echo "Response: $response\n";

// Clean up
unlink($tempFile);

echo "\n--- Simple Test Completed ---\n";
