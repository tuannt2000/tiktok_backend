<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'social_provider',
        'social_id',
        'first_name',
        'last_name',
        'nickname',
        'birthday',
        'avatar',
        'role'
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
        'tick' => 'int',
    ];

    protected $appends = ['full_name'];

    /**
     * Get the follow associated with the user.
     */
    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'user_follower_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarAttribute()
    {
        if ($this->attributes['social_provider'] === 'normal' && !is_null($this->attributes['avatar'])) {
            return env('APP_URL') . $this->attributes['avatar'];
        }
        
        return $this->attributes['avatar'];
    }
}
