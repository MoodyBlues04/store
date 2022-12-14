<?php

declare(strict_types=1);

namespace App\Models;

use App\Mail\NewUserWelcome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * 
 * @property    int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Prunable;

    const ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
    ];

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subWeek());
    }

    /**
     * The attributes that should be hidden for serialization.
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function booted()
    {
        static::created(function (User $user) {
            $user->profile()->create();

            // Doesn't work without VPN
            // Mail::to($user->email)->send(new NewUserWelcome($user));
        });

        static::deleting(function (User $user) {
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

    /**
     * Returns rated profiles
     */
    public function rated()
    {
        return $this->hasMany(Rating::class);
    }
}
