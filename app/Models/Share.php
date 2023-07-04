<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $table = 'shares';

    protected $casts = [
        'user_id' => 'int',
        'recipient_id' => 'int',
        'video_id' => 'int',
    ];

    protected $fillable = [
        'user_id', 
        'recipient_id',
        'video_id'
    ];

    public function video()
    {
        return $this->belongTo(Video::class);
    }
}
