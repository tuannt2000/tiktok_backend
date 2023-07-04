<?php

namespace App\Events;

use App\Models\Follow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $room_id, $user_id, $text, $video_id;

    /**
     * Create a new event instance.
     * @param $data
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->room_id = $data['room_id'];
        $this->user_id = $data['user_id'];
        $this->text         = $data['text'] ?? '';
        $this->video_id     = $data['video_id'] ?? 0;
    }

    public function broadcastWith()
    {
        $user = User::find($this->user_id);
        $video= null;
        if ($this->video_id != 0) {
            $video = $this->__getInfoVideo($this->user_id);
        }
        
        return [
            'user_id'  => $this->user_id,
            'room_id'  => $this->room_id,
            'nickname' => $user->nickname,
            'text'     => $this->text,
            'avatar'   => $user->avatar,
            'readed'   => 0,
            'video' => $video,
            'created_at' => date('d-m-y h:i:s')
        ];
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

    private function __getInfoVideo($user_id) {
        $users_following = Follow::ofPluckIdUserFollowing($user_id);
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }

        $video = Video::with('user')
            ->select('*')
            ->addSelect(DB::raw($select_add))
            ->where('id', $this->video_id)
            ->first();

        return $video;
    }
}
