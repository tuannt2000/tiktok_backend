<?php

namespace App\Repositories;

use App\Contracts\Repositories\NotificationRepositoryInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    /**
     * NotificationRepository constructor.
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        parent::__construct($notification);
    }

    public function getNotification() {
        $users_id = Auth::user()->id;
        return $this->model
            ->with(['user' => function ($query) use ($users_id) {
                $query->leftJoin('follows', function ($query) use ($users_id) {
                        $query->on('follows.user_follower_id', '=', 'users.id')
                            ->whereNull('follows.deleted_at')
                            ->where('follows.user_id', $users_id);
                    })
                    ->select('users.*', DB::raw('(CASE WHEN follows.user_id IS NOT NULL THEN True ELSE False END) AS is_user_following'));
            }])
            ->where('recipient_id', $users_id)
            ->where('table_name', '<>', 'messages')
            ->orderByDesc('created_at')
            ->get();
    }

    public function updateNotification() {
        $users_id = Auth::user()->id;
        return $this->model
            ->where([
                'recipient_id' => $users_id,
                'checked' => 0,
                'table_name' => 'follows'
            ])
            ->update(['checked' => 1]);
    }

    public function getNotificationsMessages() {
        $users_id = Auth::user()->id;
        return $this->model
            ->where('recipient_id', $users_id)
            ->where('table_name', 'messages')
            ->where('checked', 0)
            ->get();
    }
}