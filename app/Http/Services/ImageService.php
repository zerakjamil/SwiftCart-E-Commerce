<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    public function saveImage($image, $folder, $width = 124 , $height = 124) : string
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

    private function processImage($image, $path, $fileName, $width , $height): void
    {
        Image::read($image->path())
            ->cover($width,$height,"top")
            ->resize($width, $height,function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . '/' . $fileName);
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
}
