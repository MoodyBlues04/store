<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    
    /**
     * Stores and resize an image
     */
    public static function storeProfileImage(UploadedFile $image): string
    {
        $imagePath = $image->store('profile', 'public');
        $img = Image::make(public_path("storage/{$imagePath}"))->resize(500, 500);
        $img->save();

        return $imagePath;
    }
}