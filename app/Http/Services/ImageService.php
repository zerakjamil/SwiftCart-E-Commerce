<?php

namespace App\Http\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    public function saveImage($image, $folder, $width = 124, $height = 124): string
    {
        $fileName = $this->generateFileName($image);
        $path = public_path("uploads/$folder");

        $this->ensureDirectoryExists($path);
        $this->ensureImageExists($fileName, $folder);
        $this->processImage($image, $path, $fileName, $width, $height);

        return $fileName;
    }

    private function generateFileName($image): string
    {
        return now()->timestamp . '_' . Str::random(10) . '.' . $image->guessExtension();
    }

    public function deleteImage($image, $folder, $subFolder = ''): void
    {
        $path = public_path('uploads/' . $folder . '/' . ($subFolder ? "/$subFolder/" : '') . $image);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function deleteImages($images, $folder, $subFolder = ''): void
    {
        foreach ($images as $image) {
            $this->deleteImage($image->thumbnail, $folder, $subFolder);
        }
    }

    private function ensureDirectoryExists($path, $subFolder = ''): void
    {
        $fullPath = $path . ($subFolder ? "/$subFolder" : '');
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
    }

    private function ensureImageExists($image, $folder, $subFolder = ''): void
    {
        $path = public_path("uploads/$folder" . ($subFolder ? "/$subFolder" : '') . "/$image");
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function optimize($path)
    {
        $img = Image::make(public_path($path))->encode('jpg', 75);
        return $img->response('jpg');
    }

    private function processImage($image, $path, $fileName, $width = null, $height = null): void
    {
        $imageProcessor = Image::read($image->path());

        if ($width && $height) {
            $imageProcessor->cover($width, $height, "top")
                ->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
        }

        $imageProcessor->save($path . '/' . $fileName);
    }

    public function generateThumbnail($image, $folder, $subFolder = '', $width = 104, $height = 104): string
    {
        $fileName = $this->generateFileName($image);
        $path = public_path("uploads/$folder" . ($subFolder ? "/$subFolder" : ''));

        $this->ensureDirectoryExists($path);
        $this->ensureImageExists($fileName, $folder);
        $this->processImage($image, $path, $fileName, $width, $height);

        return $fileName;
    }

    /**
     * Save and optimize an image specifically for sliders
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @return string
     */
    public function saveSliderImage($image, $folder = 'slides'): string
    {
        $fileName = $this->generateFileName($image);
        $path = public_path("uploads/$folder");

        $this->ensureDirectoryExists($path);
        $this->ensureImageExists($fileName, $folder);
        $this->processSliderImage($image, $path, $fileName);

        return $fileName;
    }

    /**
     * Process an image specifically for sliders with optimal settings
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $path
     * @param string $fileName
     * @return void
     */
    private function processSliderImage($image, $path, $fileName): void
    {
        $originalImage = Image::read($image->path());
        $originalWidth = $originalImage->width();
        $originalHeight = $originalImage->height();

        $imageProcessor = Image::read($image->path());

        if ($originalWidth < 1200) {
            // Just optimize the image without resizing
            // For Intervention Image v3, we use the encoder() method
        } else {
            $imageProcessor->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $newHeight = $imageProcessor->height();
            if ($newHeight < 400) {
                $imageProcessor->resize(null, 400, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif ($newHeight > 1080) {
                $imageProcessor->resize(null, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        $imageProcessor->save($path . '/' . $fileName, 85);
    }
}
