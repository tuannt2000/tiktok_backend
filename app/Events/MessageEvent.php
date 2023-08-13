<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $id, $room_id;

    /**
     * Create a new event instance.
     * @param $data
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->room_id = $data['room_id'];
    }

    public function broadcastWith()
    {
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }

        $message = Message::select('users.*', 'messages.*')
            ->leftJoin('users', 'users.id', '=', 'messages.user_id')
            ->with(['video' => function($query) use($select_add) {
                return $query
                    ->select('*')   
                    ->addSelect(DB::raw($select_add))
                    ->with('user');
            }])
            ->where('messages.id', $this->id)
            ->first()
            ->toArray();
        
        return $message;
    }

    public function broadcastAs()
    {
        return 'message.new';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('room.' . $this->room_id);
    }
}
