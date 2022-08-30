<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

/**
 * Class Product
 * @package App\Models
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $characteristics
 * @property int $price
 * @property int $amount
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class Product extends Model
{
    use HasFactory;

    const PHOTO_PATH = __DIR__ . '/../../storage/app/public/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'amount',
        'image',
        'description',
        'characteristics',
    ];

    /**
     * Defines dependencies
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines dependencies
     */
    public function productPhotos()
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Stores all product photos
     * @param UploadedFile[] $photos
     * @return bool
     */
    public function storePhotos($photos)
    {
        try {
            foreach($photos as $photo) {
                $photoPath = $photo->store('product_photos', 'public');
                $photo = Image::make(public_path("storage/{$photoPath}"))->resize(610, 350);
                $photo->save();

                $this->productPhotos()->create([
                    'path' => $photoPath,
                ]);
            }
        } catch (\Exception) {
            return false;
        }
        
        return true;
    }

    /**
     * Removes old photos of current product
     * @return int count of removed files
     * @throws \Exception
     */
    public function removeOldPhotos()
    {
        $productPhotos = $this->productPhotos;
        $count = 0;
        try {
            foreach ($productPhotos as $photo) {
                $path = self::PHOTO_PATH . $photo->path;
                if (file_exists($path)) {
                    unlink($path);
                    $count++;
                }
                $photo->delete();
            }
        } catch(\Exception $exception) {
            throw $exception;
        }

        
        return $count;
    }
}
