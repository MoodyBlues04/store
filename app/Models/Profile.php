<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Profile
 * @package App\Models
 * 
 * @property    int $id
 * @property    int $user_id
 * @property string $username
 * @property string $introduction
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'username',
        'introduction',
        'image',
    ];

    public static function booted()
    {
        static::deleting(function ($profile) {
            foreach ($profile->user->products as $product) {
                $product->delete();
            }
        });
    }

    /**
     * Defines dependencies
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns users, who have rated the seller
     */
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Returns profile's image path
     * @return string
     */
    public function getImage(): string
    {
        return '/storage/' . ($this->image ?? 'profile/default.png');
    }
}
