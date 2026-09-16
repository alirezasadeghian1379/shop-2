<?php

namespace App\Services\Gallery;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Jobs\CompressVideoJob;
use App\Repositories\Gallery\Contracts\IGalleryStorageRepository;
use App\Repositories\Gallery\Models\GalleryStorage;
use App\Services\SettingService;
use GdImage;
use Illuminate\Support\Facades\Log;
use Throwable;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Format;
use Intervention\Image\Alignment;

class GalleryStorageService
{
    public function __construct(
        protected IGalleryStorageRepository $galleryStorageRepository,
        protected GalleryDbService $galleryDbService,
        protected SettingService $settingService,
    ){}


    public function upload($image,string $path,int $itemId,string $type,string $fileType = 'image'):GalleryStorage
    {
        $uploadFilePath = $image->storeAs($path,generateFileName($image),'public');
        $newGalleryDb = $this->galleryDbService->create([
            'path' => $uploadFilePath,
            'type' => $type,
            'item_id' => $itemId,
            'registered' => 1
        ]);
        try {
            $file = new File(storage_path('app/public/'.$uploadFilePath));
            $this->compressImage($file);

            $watermarkSetting = $this->settingService->findByKey('watermark_ids');
            $settingAccessWaterMarkTypes = $watermarkSetting?->value
                ? json_decode($watermarkSetting->value, true)
                : [];
            $watermarkSettingActivate = $this->settingService->findByKey('active_watermark');
            $watermarkSettingActivateValue = $watermarkSettingActivate?->value;
            if (in_array($type,$settingAccessWaterMarkTypes) && $watermarkSettingActivateValue){
                $this->createWaterMark($uploadFilePath);
            }
        } catch (Throwable $exception){
            Log::error('فشرده‌سازی تصویر ناموفق بود', [
                'path' => $uploadFilePath,
                'error' => $exception->getMessage(),
            ]);
        }
        if ($fileType == 'video'){
            CompressVideoJob::dispatch($uploadFilePath, $path,$newGalleryDb->id);
        }
        return new GalleryStorage($uploadFilePath);
    }


    public function update($image,string $path,int $itemId,string $type,?int $oldId):GalleryStorage
    {
        if (isset($oldId)){
            try {
                $this->galleryDbService->destroyByTypeId($oldId,$type);
            } catch (Throwable $th) {}
        }
        $uploadFilePath = $image->storeAs($path,generateFileName($image),'public');
        $this->galleryDbService->create([
            'path' => $uploadFilePath,
            'type' => $type,
            'item_id' => $itemId,
            'registered' => 1
        ]);
        try {
            $file = new File(storage_path('app/public/'.$uploadFilePath));
            $this->compressImage($file);
            $watermarkSetting = $this->settingService->findByKey('watermark_ids');
            $settingAccessWaterMarkTypes = $watermarkSetting?->value
                ? json_decode($watermarkSetting->value, true)
                : [];
            $watermarkSettingActivate = $this->settingService->findByKey('active_watermark');
            $watermarkSettingActivateValue = $watermarkSettingActivate?->value;
            if (in_array($type,$settingAccessWaterMarkTypes) && $watermarkSettingActivateValue){
                $this->createWaterMark($uploadFilePath);
            }
        } catch (Throwable $exception){
            Log::error('فشرده‌سازی تصویر ناموفق بود', [
                'path' => $uploadFilePath,
                'error' => $exception->getMessage(),
            ]);
        }
        return new GalleryStorage($uploadFilePath);
    }

    public function createWaterMark($imagePath)
    {
        $manager = ImageManager::usingDriver(
            Driver::class,
            autoOrientation: true,
            strip: true
        );

        $imageFullPath = storage_path(
            'app/public/' . ltrim($imagePath, '/\\')
        );

        $watermarkSetting = $this->settingService->findByKey('watermark');
        $watermarkSettingImagePath = storage_path('app/public/'.$watermarkSetting?->watermark?->path);
        $watermarkPath = empty($watermarkSetting?->watermark?->path) ? public_path('assets/images/watermark.png'):$watermarkSettingImagePath;

        if (! is_file($imageFullPath)) {
            throw new Exception(
                'فایل تصویر اصلی پیدا نشد.',
                422
            );
        }

        if (! is_file($watermarkPath)) {
            throw new Exception(
                'فایل واترمارک پیدا نشد.',
                422
            );
        }

        $image = $manager->decodePath($imageFullPath);

        $image->scale(width: 600);

        $imageWidth = $image->width();
        $imageHeight = $image->height();

        $blurWidth = (int) round(
            $imageWidth * 0.38
        );

        $blurHeight = (int) round(
            $imageHeight * 0.30
        );

        $blurX = 0;
        $blurY = $imageHeight - $blurHeight;

        $gdImage = $image->core()->native();

        if (! $gdImage instanceof GdImage) {
            throw new Exception(
                'درایور فعال تصویر GD نیست.',
                422
            );
        }

        $blurred = imagecreatetruecolor(
            $blurWidth,
            $blurHeight
        );

        if (! $blurred instanceof GdImage) {
            throw new Exception(
                'ساخت ناحیه بلور ناموفق بود.',
                422
            );
        }

        try {
            imagecopy(
                $blurred,
                $gdImage,
                0,
                0,
                $blurX,
                $blurY,
                $blurWidth,
                $blurHeight
            );

            imagefilter(
                $blurred,
                IMG_FILTER_PIXELATE,
                14,
                true
            );

            for ($i = 0; $i < 14; $i++) {
                imagefilter(
                    $blurred,
                    IMG_FILTER_GAUSSIAN_BLUR
                );
            }

            $feather = 0.18;
            $whiteTint = 0.30;

            for ($y = 0; $y < $blurHeight; $y++) {
                for ($x = 0; $x < $blurWidth; $x++) {
                    $normalizedX = $x / max(
                            1,
                            $blurWidth - 1
                        );

                    $normalizedY = (
                            ($blurHeight - 1) - $y
                        ) / max(
                            1,
                            $blurHeight - 1
                        );

                    $distance = pow(
                        pow($normalizedX, 2.8) +
                        pow($normalizedY, 2.8),
                        1 / 2.8
                    );

                    if ($distance >= 1) {
                        continue;
                    }

                    $opacity = min(
                        1,
                        max(
                            0,
                            (1 - $distance) / $feather
                        )
                    );

                    $originalColor = imagecolorat(
                        $gdImage,
                        $blurX + $x,
                        $blurY + $y
                    );

                    $blurredColor = imagecolorat(
                        $blurred,
                        $x,
                        $y
                    );

                    $originalRed = (
                            $originalColor >> 16
                        ) & 0xFF;

                    $originalGreen = (
                            $originalColor >> 8
                        ) & 0xFF;

                    $originalBlue = $originalColor & 0xFF;

                    $blurredRed = (
                            $blurredColor >> 16
                        ) & 0xFF;

                    $blurredGreen = (
                            $blurredColor >> 8
                        ) & 0xFF;

                    $blurredBlue = $blurredColor & 0xFF;

                    $blurredRed = (int) round(
                        $blurredRed * (1 - $whiteTint) +
                        255 * $whiteTint
                    );

                    $blurredGreen = (int) round(
                        $blurredGreen * (1 - $whiteTint) +
                        255 * $whiteTint
                    );

                    $blurredBlue = (int) round(
                        $blurredBlue * (1 - $whiteTint) +
                        255 * $whiteTint
                    );

                    $red = (int) round(
                        $blurredRed * $opacity +
                        $originalRed * (1 - $opacity)
                    );

                    $green = (int) round(
                        $blurredGreen * $opacity +
                        $originalGreen * (1 - $opacity)
                    );

                    $blue = (int) round(
                        $blurredBlue * $opacity +
                        $originalBlue * (1 - $opacity)
                    );

                    $red = max(0, min(255, $red));
                    $green = max(0, min(255, $green));
                    $blue = max(0, min(255, $blue));

                    $color = (
                        ($red << 16) |
                        ($green << 8) |
                        $blue
                    );

                    imagesetpixel(
                        $gdImage,
                        $blurX + $x,
                        $blurY + $y,
                        $color
                    );
                }
            }
        } finally {
            imagedestroy($blurred);
        }

        $logo = $manager->decodePath($watermarkPath);

        $logo->trim(tolerance: 2);

        $logo->scale(
            width: (int) round(
                $imageWidth * 0.15
            )
        );

        $image->insert(
            image: $logo,
            x: 25,
            y: 25,
            alignment: Alignment::BOTTOM_LEFT,
            transparency: 1
        );

        $extension = strtolower(
            pathinfo($imageFullPath, PATHINFO_EXTENSION)
        );
        $encodedImage = match ($extension) {
            'jpg', 'jpeg', 'jfif' => $image->encodeUsingFormat(
                Format::JPEG,
                quality: 90
            ),

            'png' => $image->encodeUsingFormat(
                Format::PNG
            ),

            'webp' => $image->encodeUsingFormat(
                Format::WEBP,
                quality: 90
            ),

            default => throw new Exception(
                'فرمت تصویر برای ذخیره‌سازی پشتیبانی نمی‌شود.',
                422
            ),
        };

        $encodedImage->save($imageFullPath);
    }

    public function compressImage(File|UploadedFile $file): array
    {
        $path = $file->getPathname();
        $extension = strtolower($file->getExtension());

        if (! is_file($path)) {
            throw new Exception('فایل تصویر پیدا نشد.', 422);
        }

        if (! in_array($extension, ['jpg', 'jpeg', 'jfif', 'png', 'webp'], true)) {
            throw new Exception('فرمت تصویر پشتیبانی نمی‌شود.', 422);
        }

        $before = filesize($path);

        if ($before === false) {
            throw new Exception('حجم فایل قابل خواندن نیست.', 422);
        }

        $manager = ImageManager::usingDriver(
            Driver::class,
            autoOrientation: true,
            strip: true
        );

        $image = $manager
            ->decodePath($path)
            ->scaleDown(width: 1600);

        $compressed = match ($extension) {
            'jpg', 'jpeg', 'jfif' => $image->encodeUsingFormat(
                Format::JPEG,
                quality: 75
            ),

            'png' => $image->encodeUsingFormat(
                Format::PNG
            ),

            'webp' => $image->encodeUsingFormat(
                Format::WEBP,
                quality: 75
            ),
        };

        $data = (string) $compressed;
        $compressedSize = strlen($data);

        if ($compressedSize < $before) {
            $written = file_put_contents(
                $path,
                $data,
                LOCK_EX
            );

            if ($written === false || $written !== $compressedSize) {
                throw new Exception('نوشتن کامل فایل ناموفق بود.', 422);
            }
        }

        clearstatcache(true, $path);

        $finalSize = filesize($path);

        return [
            'file' => $file->getFilename(),
            'before_kb' => round($before / 1024),
            'after_kb' => $finalSize !== false ? round($finalSize / 1024) : null,
        ];
    }
}
