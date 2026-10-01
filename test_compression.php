<?php

/**
 * Test image compression functionality
 */

// Create a larger test image to see compression in action
$width = 1200;
$height = 900;
$image = imagecreatetruecolor($width, $height);

// Create a more complex image with gradients
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $red = (int) (255 * ($x / $width));
        $green = (int) (255 * ($y / $height));
        $blue = (int) (255 * (($x + $y) / ($width + $height)));
        $color = imagecolorallocate($image, $red, $green, $blue);
        imagesetpixel($image, $x, $y, $color);
    }
}

// Add some text
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 400, 350, 800, 550, $white);
imagestring($image, 5, 450, 400, 'COMPRESSION TEST', $black);
imagestring($image, 5, 470, 450, $width.'x'.$height, $black);
imagestring($image, 3, 480, 500, 'Original large image', $black);

$tempFile = tempnam(sys_get_temp_dir(), 'compression_test_').'.png';
imagepng($image, $tempFile, 0); // Save as PNG with no compression for testing
imagedestroy($image);

echo "Created large test image: $tempFile\n";
echo 'Original file size: '.number_format(filesize($tempFile))." bytes\n";
echo "Original dimensions: {$width}x{$height}\n\n";

// Test compression with debug endpoint
$url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';

$postData = [
    'profile_image' => new CURLFile($tempFile, 'image/png', 'compression-test.png'),
];

$headers = ['Accept: application/json'];

echo "=== Testing Image Compression ===\n";

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
    echo "✅ SUCCESS - Image compression worked!\n\n";
    $responseData = json_decode($response, true);

    if (isset($responseData['data'])) {
        $data = $responseData['data'];
        echo "Compressed Results:\n";
        echo '- File Path: '.$data['file_path']."\n";
        echo '- Final Size: '.number_format($data['file_size'])." bytes\n";
        echo '- Final Dimensions: '.$data['width'].'x'.$data['height']."\n";
        echo '- MIME Type: '.$data['mime_type']."\n";
        echo '- Format: '.$data['file_format']."\n";

        $compressionRatio = round((1 - ($data['file_size'] / filesize($tempFile))) * 100, 2);
        echo "- Compression Ratio: {$compressionRatio}%\n";

        if ($data['width'] <= 800 && $data['height'] <= 800) {
            echo "✅ Image properly resized to max 800px\n";
        }

        if ($data['mime_type'] === 'image/jpeg' && $data['file_format'] === 'jpg') {
            echo "✅ Image converted to JPEG format\n";
        }
    }
} else {
    echo "❌ Response: $response\n";
}

// Clean up
unlink($tempFile);

echo "\n--- Compression Test Completed ---\n";
