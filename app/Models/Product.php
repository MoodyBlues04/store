<?php

declare(strict_types=1);

namespace App\Models;

use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

/**
 * Class Product
 * @package App\Models
 * 
 * @property    int $id
 * @property    int $user_id
 * @property string $name
 * @property string $description
 * @property string $characteristics
 * @property    int $price
 * @property    int $amount
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
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

    public static function booted()
    {
        static::deleting(function ($product) {
            $repository = new ProductRepository();
            $repository->removeImageById($product->id);
            $repository->removePhotosById($product->id);
        });
    }
}
