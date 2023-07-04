<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    /**
     * MessageRepository constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    public function getListMessages($room_id, $users_following)
    {
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }

        $messages = $this->model
            ->leftJoin('users', 'users.id', '=', 'messages.user_id')
            ->with(['video' => function($query) use($select_add) {
                return $query
                    ->select('*')   
                    ->addSelect(DB::raw($select_add))
                    ->with('user');
            }])
            ->where('room_id', $room_id)
            ->orderBy('messages.date_send', 'DESC')
            ->take(20)
            ->get();

        return $messages;
    }

    public function store($params)
    {
        return $this->model->create($params);
    }
}