<?php

namespace App\Models;

use App\Events\NotificationEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $casts = [
        'user_id' => 'int',
        'recipient_id'  => 'int',
        'table_id'  => 'int'
    ];

    protected $fillable = [
        'user_id',
        'recipient_id',
        'table_id',
        'table_name',
        'checked'
    ];

    public static function booted()
    {
        static::created(function($notification){
            if ($notification->checked) {
                return;
            }
            event(new NotificationEvent($notification));
            $notification->update(['checked' => true]);
        });

        static::updated(function($notification){
            if ($notification->checked) {
                return;
            }
            event(new NotificationEvent($notification));
            $notification->update(['checked' => true]);
        });
    }
}
