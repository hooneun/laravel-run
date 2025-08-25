<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class AvatarService
{
    public function resizeImage(UploadedFile $file, string $filename, int $width = 150, int $height = 150): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath());
        $resizedImage = $image->resize($width, $height);

        $avatarPath = 'avatars/' . $filename;
        $imageData = $resizedImage->encode(new JpegEncoder(quality: 90))->toString();

        Storage::disk('public')->put($avatarPath, $imageData);

        return $avatarPath;
    }

    public function deleteExistingAvatar(?string $avatarPath): bool
    {
        if (!$avatarPath) {
            return true;
        }

        if (Storage::disk('public')->exists($avatarPath)) {
            return Storage::disk('public')->delete($avatarPath);
        }

        return true;
    }
}
