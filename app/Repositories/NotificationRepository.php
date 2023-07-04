<?php

namespace App\Repositories;

use App\Contracts\Repositories\NotificationRepositoryInterface;
use App\Models\Notification;

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
}