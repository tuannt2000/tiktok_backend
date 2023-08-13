<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $users_id = $this->notification->recipient_id;
            $notification = Notification::where('id', $this->notification->id)
                ->with(['user' => function ($query) use ($users_id) {
                    $query->leftJoin('follows', function ($query) use ($users_id) {
                            $query->on('follows.user_follower_id', '=', 'users.id')
                                ->whereNull('follows.deleted_at')
                                ->where('follows.user_id', $users_id);
                        })
                        ->select('users.*', DB::raw('(CASE WHEN follows.user_id IS NOT NULL THEN True ELSE False END) AS is_user_following'));
                }])
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
