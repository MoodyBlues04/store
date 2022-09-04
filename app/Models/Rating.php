<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 * @package App\Models
 * 
 * @property    int $id
 * @property    int $user_id
 * @property    int $profile_id
 * @property    int $value
 * @property string $created_at
 * @property string $updated_at
 */
class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'profile_id',
        'value',
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
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
