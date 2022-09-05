<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductPhoto
 * @package App\MOdels
 * 
 * @property    int $id
 * @property    int $product_id
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class ProductPhoto extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'path',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    /**
     * Defines dependencies
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
