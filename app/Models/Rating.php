<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property string $deleted_at
 */
class Rating extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'profile_id',
        'value',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

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
