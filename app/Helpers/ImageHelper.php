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

    public static function storeProductPhoto(UploadedFile $photo): string
    {
        $photoPath = $photo->store('product_photos', 'public');
        $photo = Image::make(public_path("storage/{$photoPath}"))->resize(610, 350);
        $photo->save();

        return $photoPath;
    }

    public static function storeProductImage(UploadedFile $image): string
    {
        $imagePath = $image->store('product_images', 'public');
        $img = Image::make(public_path("storage/{$imagePath}"))->resize(610, 350);
        $img->save();

        return $imagePath;
    }
}