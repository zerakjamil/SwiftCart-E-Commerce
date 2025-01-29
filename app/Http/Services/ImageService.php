<?php

namespace App\Http\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    public function saveImage($image, $folder): string
    {
        $fileName = $this->generateFileName($image);
        $path = public_path("uploads/$folder");

        $this->ensureDirectoryExists($path);
        $this->ensureImageExists($fileName, $folder);
        $this->processImage($image, $path, $fileName);

        return $fileName;
    }

    private function generateFileName($image): string
    {
        return now()->timestamp . '_' . Str::random(10) . '.' . $image->guessExtension();
    }

    private function ensureDirectoryExists($path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    private function ensureImageExists($image, $folder): void
    {
        if (!File::exists(public_path("uploads/$folder/$image"))) {
            File::delete(public_path("uploads/$folder/$image"));
        }
    }

    public function deleteImage($image, $folder): void
    {
        if (File::exists(public_path('uploads/' . $folder . '/' . $image))) {
            File::delete(public_path('uploads/' . $folder . '/' . $image));
        }
    }

    private function processImage($image, $path, $fileName): void
    {
        Image::read($image->path())
            ->cover(124,124,"top")
            ->resize(124, 124,function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . '/' . $fileName);
    }
}
