<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $casts = [
        'video_id' => 'int',
        'user_id'  => 'int'
    ];

    protected $fillable = [
        'video_id', 
        'user_id',
        'value',
        'progress'
    ];
}
