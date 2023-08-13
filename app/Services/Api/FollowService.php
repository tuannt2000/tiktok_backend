<?php

namespace App\Services\Api;

use App\Contracts\Repositories\FollowRepositoryInterface;
use App\Contracts\Repositories\RoomRepositoryInterface;
use App\Contracts\Services\Api\FollowServiceInterface;
use App\Models\Notification;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FollowService extends AbstractService implements FollowServiceInterface
{
    /**
     * @var FollowRepositoryInterface
     */
    protected $followRepository;

    /**
     * @var RoomRepositoryInterface
     */
    protected $roomRepository;

    /**
     * FollowService constructor.
     * @param FollowRepositoryInterface $followRepository
     * @param RoomRepositoryInterface $roomRepository
     */
    public function __construct(FollowRepositoryInterface $followRepository, RoomRepositoryInterface $roomRepository)
    {
        $this->followRepository = $followRepository;
        $this->roomRepository = $roomRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $follow = $this->followRepository->findFollow($data);
            if (is_null($follow)) {
                $follow = $this->followRepository->create([
                    'user_id' => Auth::user()->id,
                    'user_follower_id' => $data['user_follower_id']
                ]);
            } else {
                if (is_null($follow->deleted_at)) {
                    $follow->delete();
                } else {
                    $follow->restore();
                }
            }

            if (!$this->__createRoom([Auth::user()->id, $data['user_follower_id']])) {
                throw new \Exception('Could not create room');
            }
           
            $option_notification = [
                'user_id' => Auth::user()->id,
                'recipient_id' => $data['user_follower_id'],
                'table_name' => 'follows'
            ];
            $notification = Notification::where($option_notification)->first();
            if (is_null($follow->deleted_at)) {
                if (!$notification) {
                    $option_notification['table_id'] = $follow->id;
                    Notification::create($option_notification);
                }
            } else {
                if ($notification) {
                    $notification->delete();
                }
            }
            DB::commit();

            return [
                'code' => 200
            ];
        } catch (\Throwable $err) {
            DB::rollBack();
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    private function __createRoom($users_id = []) {
        $follows = $this->followRepository->getFollowAlong($users_id);
        $rooms = $this->roomRepository->getRoomCreated($users_id);
        try {
            if ($follows->count() == 2) {
                if (is_null($rooms)) {
                    $this->roomRepository->createRoom($users_id);
                } else {
                    $this->roomRepository->restoreRoomCreated($rooms->room_id);
                }
            } else {
                if ($rooms) {
                    $this->roomRepository->deleteRoomCreated($rooms->room_id);
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error($e);
        }

        return false;
    }
}
