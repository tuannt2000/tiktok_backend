<?php

namespace App\Services\Api;

use App\Contracts\Repositories\NotificationRepositoryInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Services\Api\RoomServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Log;

class RoomService extends AbstractService implements RoomServiceInterface
{
    /**
     * @var RoomRepositoryInterface
     */
    protected $roomRepository;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $notificationRepository;

    /**
     * RoomService constructor.
     * @param RoomRepositoryInterface $roomRepository
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        RoomRepositoryInterface $roomRepository,
        NotificationRepositoryInterface $notificationRepository
    )
    {
        $this->roomRepository = $roomRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param $user_id
     * @return array
     */
    public function index($user_id)
    {
        try {
            $room_user = $this->roomRepository->findRooms($user_id);
            $list_room = $this->roomRepository->findAllRooms($room_user, $user_id);
            return [
                'code' => 200,
                'data' => $list_room
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }

    /**
     * @param $notification_id
     * @return array
     */
    public function removeNotification($notification_id)
    {
        try {
            $notification = $this->notificationRepository->findOrFail($notification_id);
            $this->notificationRepository->delete($notification->id);

            return [
                'code' => 200,
                'message' => "Delete notification successfully"
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }
}
