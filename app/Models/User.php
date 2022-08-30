<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * 
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        static::created(function ($user) {
            $user->profile()->create();
        });

        static::deleting(function ($user) {
            $user->profile()->delete();
        });
    }

    /**
     * Defines dependencies
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Defines dependencies
     */
    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('created_at', 'DESC');
    }
}
