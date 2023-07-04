<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    /**
     * RoomRepository constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function findRooms($user_id) {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function findAllRooms($room_user, $user_id) {
        $rooms_id = [];
        foreach ($room_user as $value) {
            $rooms_id[] = $value->room_id;
        }

        $list_room = $this->model
            ->select(
                'm1.user_id as text_user_id',
                'rooms.user_id as room_user_id',
                'rooms.room_id as room_id',
                'users.nickname',
                'users.avatar',
                'users.social_provider',
                'm1.text',
                'm1.video_id',
                'notifications.id as notification_id',
                DB::raw('(CASE 
                        WHEN m1.date_send is NULL THEN rooms.created_at
                        ELSE m1.date_send
                        END) AS created_at'),
                DB::raw('(CASE 
                        WHEN notifications.id is NULL THEN 1
                        ELSE 0
                        END) AS readed')
            )
            ->leftJoin('users', 'users.id', '=', 'rooms.user_id')
            ->leftJoin('messages as m1', function ($query) use ($user_id) {
                $query->on('m1.room_id', '=', 'rooms.room_id');
                $query->whereRaw('m1.date_send = (select max(m2.date_send) from messages as m2 where m2.room_id = m1.room_id and rooms.user_id !=' . $user_id . ')');
            })
            ->leftJoin('notifications', function ($query) use ($user_id) {
                $query->on('notifications.table_id', '=', 'm1.id');
                $query->where('notifications.table_name', 'messages')
                    ->where('notifications.user_id', '!=', $user_id);
            })
            ->whereIn('rooms.room_id', $rooms_id)
            ->where('rooms.user_id', '!=', $user_id)
            ->get();

        return $list_room;
    }

    public function createRoom($users_id) {
        $count = $this->model->withTrashed()->count();
        $room_id = $count/2 + 1;
        $query = $this->model->insert([
            [
                'room_id' => $room_id,
                'user_id' => $users_id[0],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => $room_id,
                'user_id' => $users_id[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        return $query;
    }

    public function getRoomCreated($users_id) {
        $rooms = $this->model
            ->withTrashed()
            ->select(DB::raw("count(room_id) as count"), 'room_id')
            ->whereIn('user_id', $users_id)
            ->groupBy('room_id')
            ->having('count', 2)
            ->first();

        return $rooms;
    }

    public function deleteRoomCreated($room_id) {
        $this->model
            ->where('room_id', $room_id)
            ->delete();
    }

    public function restoreRoomCreated($room_id) {
        $this->model
            ->withTrashed()
            ->where('room_id', $room_id)
            ->restore();
    }

    public function findRoomIdByUserId($user_id) {
        $room = DB::table('rooms AS r1')
            ->select('r1.room_id')
            ->join('rooms AS r2', 'r2.room_id', '=', 'r1.room_id')
            ->where('r2.user_id', $user_id)
            ->where('r1.user_id', Auth::user()->id)
            ->whereNull('r1.deleted_at')
            ->whereNull('r2.deleted_at')
            ->first();

        if (!is_null($room)) {
            return $room->room_id;
        }

        return null;
    }
}