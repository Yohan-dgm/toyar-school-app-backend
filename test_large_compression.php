<?php

/**
 * Test image compression with large image that needs resizing
 */

// Create a large test image that will trigger resizing
$width = 1600;
$height = 1200;
$image = imagecreatetruecolor($width, $height);

// Create a pattern with multiple colors
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $red = (int) (255 * sin($x / 100));
        $green = (int) (255 * sin($y / 100));
        $blue = (int) (255 * sin(($x + $y) / 100));
        $color = imagecolorallocate($image, abs($red), abs($green), abs($blue));
        imagesetpixel($image, $x, $y, $color);
    }
}

// Add large text
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 600, 500, 1000, 700, $white);
imagestring($image, 5, 650, 550, 'LARGE IMAGE TEST', $black);
imagestring($image, 5, 700, 600, $width.'x'.$height, $black);

$tempFile = tempnam(sys_get_temp_dir(), 'large_test_').'.jpg';
imagejpeg($image, $tempFile, 95); // High quality original
imagedestroy($image);

echo "Created large test image: $tempFile\n";
echo 'Original file size: '.number_format(filesize($tempFile))." bytes\n";
echo "Original dimensions: {$width}x{$height}\n";
echo "Should be resized to max 800x600 (proportional)\n\n";

// Test with debug endpoint
$url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';

$postData = [
    'profile_image' => new CURLFile($tempFile, 'image/jpeg', 'large-test.jpg'),
];

$headers = ['Accept: application/json'];

echo "=== Testing Large Image Compression & Resize ===\n";

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
    echo "✅ SUCCESS - Large image processed!\n\n";
    $responseData = json_decode($response, true);

    if (isset($responseData['data'])) {
        $data = $responseData['data'];
        $originalSize = filesize($tempFile);

        echo "Processing Results:\n";
        echo '- Original Size: '.number_format($originalSize)." bytes\n";
        echo '- Compressed Size: '.number_format($data['file_size'])." bytes\n";
        echo "- Original Dimensions: {$width}x{$height}\n";
        echo '- Final Dimensions: '.$data['width'].'x'.$data['height']."\n";
        echo '- MIME Type: '.$data['mime_type']."\n";
        echo '- Format: '.$data['file_format']."\n";

        $compressionRatio = round((1 - ($data['file_size'] / $originalSize)) * 100, 2);
        echo "- Compression Ratio: {$compressionRatio}%\n\n";

        if ($data['width'] <= 800 && $data['height'] <= 800) {
            echo "✅ Image properly resized to within 800x800 limit\n";
        } else {
            echo "❌ Image not properly resized\n";
        }

        if ($data['mime_type'] === 'image/jpeg' && $data['file_format'] === 'jpg') {
            echo "✅ Image converted to JPEG format\n";
        } else {
            echo "❌ Image not properly converted to JPEG\n";
        }

        if ($compressionRatio > 0) {
            echo "✅ Image size reduced by {$compressionRatio}%\n";
        }
    }
} else {
    echo "❌ Response: $response\n";
}

// Clean up
unlink($tempFile);

echo "\n--- Large Image Test Completed ---\n";
