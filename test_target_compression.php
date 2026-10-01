<?php

/**
 * Test target-based compression (200KB-500KB range)
 */
function createTestImage($width, $height, $complexity = 'medium')
{
    $image = imagecreatetruecolor($width, $height);

    if ($complexity === 'simple') {
        // Simple solid colors
        $colors = [
            imagecolorallocate($image, 255, 100, 100),
            imagecolorallocate($image, 100, 255, 100),
            imagecolorallocate($image, 100, 100, 255),
        ];

        for ($i = 0; $i < count($colors); $i++) {
            imagefilledrectangle($image,
                ($width / count($colors)) * $i, 0,
                ($width / count($colors)) * ($i + 1), $height,
                $colors[$i]
            );
        }
    } elseif ($complexity === 'medium') {
        // Gradients - medium complexity
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $red = (int) (255 * ($x / $width));
                $green = (int) (255 * ($y / $height));
                $blue = (int) (255 * (($x + $y) / ($width + $height)));
                $color = imagecolorallocate($image, $red, $green, $blue);
                imagesetpixel($image, $x, $y, $color);
            }
        }
    } else { // complex
        // Complex patterns - high detail
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $red = (int) (255 * abs(sin($x / 50) * cos($y / 50)));
                $green = (int) (255 * abs(sin($x / 30) * sin($y / 40)));
                $blue = (int) (255 * abs(cos($x / 20) * cos($y / 60)));
                $color = imagecolorallocate($image, $red, $green, $blue);
                imagesetpixel($image, $x, $y, $color);
            }
        }
    }

    // Add text
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $textX = (int) ($width * 0.3);
    $textY = (int) ($height * 0.4);

    imagefilledrectangle($image, $textX, $textY, $textX + 200, $textY + 100, $white);
    imagestring($image, 5, $textX + 10, $textY + 20, 'TARGET TEST', $black);
    imagestring($image, 3, $textX + 20, $textY + 50, $width.'x'.$height, $black);
    imagestring($image, 3, $textX + 30, $textY + 70, strtoupper($complexity), $black);

    return $image;
}

function testImageCompression($name, $width, $height, $complexity, $format = 'jpg')
{
    echo "\n=== Testing: $name ===\n";

    $image = createTestImage($width, $height, $complexity);
    $tempFile = tempnam(sys_get_temp_dir(), 'target_test_').'.'.$format;

    if ($format === 'png') {
        imagepng($image, $tempFile, 0); // No compression for testing
    } else {
        imagejpeg($image, $tempFile, 95); // High quality original
    }

    imagedestroy($image);

    $originalSize = filesize($tempFile);
    echo "Original: {$width}x{$height}, ".number_format($originalSize)." bytes, $complexity complexity\n";

    // Test with debug endpoint
    $url = 'http://127.0.0.1:8000/api/user-management/user-profile/debug-upload-profile-photo';
    $postData = ['profile_image' => new CURLFile($tempFile, 'image/'.$format, $name.'.'.$format)];
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
    curl_close($ch);

    unlink($tempFile);

    if ($httpCode === 201) {
        $data = json_decode($response, true)['data'];
        $finalSize = $data['file_size'];
        $targetRange = '200KB-500KB';
        $inRange = ($finalSize >= 204800 && $finalSize <= 512000);
        $compressionRatio = round((1 - ($finalSize / $originalSize)) * 100, 2);

        echo "Final: {$data['width']}x{$data['height']}, ".number_format($finalSize).' bytes ('.round($finalSize / 1024, 1)."KB)\n";
        echo "Compression: {$compressionRatio}% reduction\n";
        echo 'Target Range: '.($inRange ? '✅ ACHIEVED' : '❌ MISSED')." ({$targetRange})\n";

        if (isset($data['compression_iterations'])) {
            echo 'Iterations: '.$data['compression_iterations']."\n";
        }
    } else {
        echo "❌ FAILED: $response\n";
    }
}

echo "Testing Target-Based Compression (200KB-500KB)\n";
echo "============================================\n";

// Test various image sizes and complexities
testImageCompression('small-simple', 400, 300, 'simple');
testImageCompression('small-complex', 400, 300, 'complex');
testImageCompression('medium-simple', 800, 600, 'simple');
testImageCompression('medium-complex', 800, 600, 'complex');
testImageCompression('large-simple', 1200, 900, 'simple');
testImageCompression('large-complex', 1200, 900, 'complex');
testImageCompression('xlarge-simple', 1600, 1200, 'simple');
testImageCompression('xlarge-complex', 1600, 1200, 'complex');

echo "\n--- Target Compression Tests Completed ---\n";
