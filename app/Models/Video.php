<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'path_directory',
        'cover_image',
        'url',
        'description',
        'status',
        'comment',
        'date_upload'
    ];

    protected $casts = [
        'user_id' => 'int',
        'status'  => 'int',
        'comment' => 'int',
        'is_user_following' => 'int',
        'likes_count' => 'int',
        'comments_count' => 'int',
        'shares_count' => 'int',
    ];

    protected $table = 'videos';

    protected static function boot() {
        parent::boot();
        static::deleting(function($video) { // before delete() method call this
            $video->likes()->delete();
            $video->comments()->delete();
        });
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'user_follower_id', 'user_id');
    }

    public function getStatusText()
    {
        $status = $this->status;
        $status_text = '';
        if ($status == 0) {
            $status_text = "Công khai";
        } else if ($status == 1) {
            $status_text = "Bạn bè";
        } else if ($status == 2) {
            $status_text = "Cá nhân";
        }

        return $status_text;
    }

    public function getUrlAttribute()
    {
        return Storage::disk('google')->url($this->attributes['url']);
    }

    public function getCoverImageAttribute()
    {
        return Storage::disk('google')->url($this->attributes['cover_image']);
    }
}
