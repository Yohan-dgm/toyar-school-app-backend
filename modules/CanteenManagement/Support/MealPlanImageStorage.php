<?php

namespace Modules\CanteenManagement\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MealPlanImageStorage
{
    private const STORAGE_PATH = 'canteen/meal_plan_images';
    private const MAX_DIMENSION = 1200;
    private const QUALITY = 80;

    /**
     * Resize/compress and store the uploaded meal-plan image, returning the
     * path to save on the model's image_path column.
     */
    public static function store(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname());

        if ($image->width() > self::MAX_DIMENSION || $image->height() > self::MAX_DIMENSION) {
            $image->scaleDown(width: self::MAX_DIMENSION, height: self::MAX_DIMENSION);
        }

        $content = (string) $image->toJpeg(self::QUALITY);
        $filename = 'meal_plan-'.microtime(true).'.jpg';
        $path = self::STORAGE_PATH.'/'.$filename;

        Storage::disk('public')->put($path, $content);

        return $path;
    }

    public static function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
