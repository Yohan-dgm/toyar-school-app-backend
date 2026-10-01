<?php

/**
 * Quick test of updated target-based compression
 */

// Create a high-detail test image
$width = 1200;
$height = 900;
$image = imagecreatetruecolor($width, $height);

// Create complex high-detail pattern
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $red = (int) (255 * abs(sin($x / 20) * cos($y / 30)));
        $green = (int) (255 * abs(sin($x / 25) * sin($y / 35)));
        $blue = (int) (255 * abs(cos($x / 15) * cos($y / 40)));
        $color = imagecolorallocate($image, $red, $green, $blue);
        imagesetpixel($image, $x, $y, $color);
    }
}

// Add text
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 400, 300, 800, 600, $white);
imagestring($image, 5, 450, 350, 'UPDATED TARGET TEST', $black);
imagestring($image, 5, 500, 400, '1200x900', $black);
imagestring($image, 3, 520, 450, 'High Detail', $black);
imagestring($image, 3, 490, 500, 'Target: 200-500KB', $black);

$tempFile = tempnam(sys_get_temp_dir(), 'updated_test_').'.jpg';
imagejpeg($image, $tempFile, 95); // High quality original
imagedestroy($image);

echo "Quick Target Test\n";
echo "================\n";
echo "Created test image: $tempFile\n";
echo 'Original size: '.number_format(filesize($tempFile)).' bytes ('.round(filesize($tempFile) / 1024, 1)."KB)\n";
echo "Original dimensions: {$width}x{$height}\n";
echo "Target: 200KB-500KB\n\n";

// Test with debug endpoint
$url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';

$postData = [
    'profile_image' => new CURLFile($tempFile, 'image/jpeg', 'updated-target-test.jpg'),
];

$headers = ['Accept: application/json'];

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
    echo "✅ SUCCESS!\n\n";
    $data = json_decode($response, true)['data'];
    $originalSize = filesize($tempFile);
    $finalSize = $data['file_size'];
    $targetMin = 204800; // 200KB
    $targetMax = 512000; // 500KB
    $inRange = ($finalSize >= $targetMin && $finalSize <= $targetMax);

    echo "Results:\n";
    echo '- Original Size: '.number_format($originalSize).' bytes ('.round($originalSize / 1024, 1)."KB)\n";
    echo '- Final Size: '.number_format($finalSize).' bytes ('.round($finalSize / 1024, 1)."KB)\n";
    echo '- Final Dimensions: '.$data['width'].'x'.$data['height']."\n";
    echo '- Format: '.$data['file_format'].' ('.$data['mime_type'].")\n";

    $compressionRatio = round((1 - ($finalSize / $originalSize)) * 100, 2);
    echo "- Compression: {$compressionRatio}% reduction\n";

    echo "\nTarget Analysis:\n";
    echo "- Target Range: 200KB - 500KB\n";
    echo '- Achieved: '.($inRange ? '✅ YES' : '❌ NO')."\n";

    if (! $inRange) {
        if ($finalSize < $targetMin) {
            echo '- Status: Too small (need '.round(($targetMin - $finalSize) / 1024, 1)."KB more)\n";
        } else {
            echo '- Status: Too large (need '.round(($finalSize - $targetMax) / 1024, 1)."KB less)\n";
        }
    } else {
        echo "- Status: Perfect! Within target range\n";
    }
} else {
    echo "❌ FAILED\n";
    echo "Response: $response\n";
}

// Clean up
unlink($tempFile);

echo "\n--- Quick Test Completed ---\n";
