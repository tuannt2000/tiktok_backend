<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'follows';

    protected $casts = [
        'user_id' => 'int',
        'user_follower_id' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_follower_id',
        'deleted_at'
    ];

    /**
     * Get the user associated with the follow.
     */
    public function currentUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userFollowing()
    {
        return $this->hasOne(User::class, 'id', 'user_follower_id');
    }

    public function scopeOfListIdUserFollowing($query, $user_id)
    {
        return $query->select('user_follower_id')->where('user_id', $user_id)->get()->toArray();
    }

    public function scopeOfPluckIdUserFollowing($query, $user_id)
    {
        return $query->where('user_id', $user_id)->pluck('user_follower_id')->toArray();
    }

    // số lượng người đang follow
    public function scopeOfFollowingCount($query, $user_id)
    {
        return $query->where('user_id', $user_id)->count();
    }

    // số lượng người bản thân follow
    public function scopeOfFollowerCount($query, $user_id)
    {
        return $query->where('user_follower_id', $user_id)->count();
    }

    public function scopeOfListIdFriend($query, $user_id)
    {
        $users_following = $this->ofListIdUserFollowing($user_id);

        return $query->whereIn('user_id', $users_following)
            ->where('user_follower_id', $user_id)
            ->pluck('user_id')
            ->toArray();
    }
}
