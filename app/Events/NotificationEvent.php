<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
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
            $notification = Notification::findOrFail($this->notification->id);
            return [
                'id'           => $notification->id,
                'user_id'      => $notification->user_id,
                'recipient_id' => $notification->recipient_id,
                'table_name'   => $notification->table_name
            ];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function broadcastAs()
    {
        return 'notification.new';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notification.' . $this->notification->recipient_id);
    }
}
