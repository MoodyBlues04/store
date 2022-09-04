<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductPhoto
 * @package App\MOdels
 * 
 * @property    int $id
 * @property    int $product_id
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 */
class ProductPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'path',
    ];

    /**
     * Defines dependencies
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
