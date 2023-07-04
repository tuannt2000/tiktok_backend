<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';

    protected $casts = [
        'room_id' => 'int',
        'user_id' => 'int',
        'room_user_id' => 'int',
        'text_user_id' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'user_id',
        'deleted_at'
    ];

    protected $appends = ['avatar', 'social_provider'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeOfUsersByRoomId($query, $room_id, $user_id)
    {
        return $query->select('user_id')
            ->where('room_id', $room_id)
            ->where('user_id', "<>", $user_id)
            ->first();
    }

    public function getSocialProviderAttribute()
    {
        return $this->attributes['social_provider'];
    }

    public function getAvatarAttribute()
    {
        if ($this->attributes['social_provider'] === 'normal' && !is_null($this->attributes['avatar'])) {
            return env('APP_URL') . $this->attributes['avatar'];
        }
        
        return $this->attributes['avatar'];
    }
}
