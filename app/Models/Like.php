<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'likes';

    protected $casts = [
        'user_id'  => 'int',
        'video_id' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'video_id',
        'deleted_at'
    ];

    public function scopeOfLikesCount($query, $user_id)
    {
        return $query
            ->join('videos', 'videos.id', '=', 'likes.video_id')
            ->where('videos.user_id', $user_id)
            ->distinct('likes.user_id')->count();
    }
}
