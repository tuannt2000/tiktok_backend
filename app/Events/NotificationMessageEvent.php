<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $notification;

    /**
     * Create a new event instance.
     * @param $data
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastWith()
    {
        try {
            $notification = Notification::where('id', $this->notification->id)
                ->first()
                ->toArray();
            return $notification;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function broadcastAs()
    {
        return 'notification_message.new';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notification_message.' . $this->notification->recipient_id);
    }
}
