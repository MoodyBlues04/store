<?php

declare(strict_types=1);

namespace App\Repository;

use App\Helpers\ImageHelper;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use Intervention\Image\Facades\Image;

class ProductRepository
{
    public const STORAGE_PATH = __DIR__ . '/../../storage/app/public/';

    public function getLatestPaginated(): Paginator
    {
        return Product::with('user')->latest()->simplePaginate(10);
    }

    /**
     * Stores product photos
     * @param UploadedFile[] $photos
     */
    public function storePhotosById(int $id, $photos): bool
    {
        $product = Product::findOrFail($id);

        try {
            foreach($photos as $photo) {
                $photoPath = ImageHelper::storeProductPhoto($photo);

                $product->productPhotos()->create([
                    'path' => $photoPath,
                ]);
            }
        } catch (\Exception) {
            return false;
        }
        
        return true;
    }

    /**
     * Removes old photos of product
     * @throws \Exception
     * @return int count of removed files
     */
    public function removePhotosById(int $id): int
    {
        $product = Product::findOrFail($id);
        $productPhotos = $product->productPhotos;
        $count = 0;

        foreach ($productPhotos as $photo) {
            $path = self::STORAGE_PATH . $photo->path;
            if (file_exists($path)) {
                unlink($path);
                $count++;
            }
            $photo->delete();
        }

        return $count;
    }

    /**
     * Removes old image of current product
     * @throws \Exception
     */
    public function removeImageById(int $id): void
    {
        $product = Product::findOrFail($id);

        $path = self::STORAGE_PATH . $product->image;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}