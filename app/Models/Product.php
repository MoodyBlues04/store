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
}
