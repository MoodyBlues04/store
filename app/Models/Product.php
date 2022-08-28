<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property dateTime $created_at
 * @property dateTime $updated_at
 */
class Product extends Model
{
    use HasFactory;

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
                $photoPath = $photo->store('uploads', 'public');

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
     * @return int|bool count of removed files | fail
     */
    public function removeOldPhotos()
    {
        $productPhotos = $this->productPhotos;
        $count = 0;
        try {
            foreach ($productPhotos as $photo) {
                unlink(__DIR__ . '/../../../storage/app/public/' . $photo->path);
                $count++;
            }
        } catch(\Exception) {
            return false;
        }
        
        return $count;
    }
}
