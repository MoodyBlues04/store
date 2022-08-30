<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App\Models
 * 
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $introduction
 * @property string $image
 * @property string $created_at
 */
class Profile extends Model
{
    use HasFactory;

    public const STORAGE_PATH = __DIR__ . '/../../storage/app/public/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'introduction',
        'image',
    ];

    /**
     * Defines dependencies
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Removes old profile's image
     * @return void
     */
    public function removeImage()
    {
        if (isset($this->image)) {
            $path = self::STORAGE_PATH . $this->image;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
