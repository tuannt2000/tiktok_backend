<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/6/2022
 * Time: 3:20 PM
 */

namespace App\Services\Api;

use App\Contracts\Repositories\FollowRepositoryInterface;
use App\Contracts\Repositories\NotificationRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Models\Follow;
use App\Models\Like;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var FollowRepositoryInterface
     */
    protected $followRepository;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $notificationRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        FollowRepositoryInterface $followRepository,
        NotificationRepositoryInterface $notificationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->followRepository = $followRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @return array
     */
    public function index()
    {
        try {
            $data = $this->userRepository->getAll();

            return [
                'code' => 200,
                'data' => $data
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
     * @param $params
     * @return array
     */
    public function findUserByKey($params)
    {
        try {
            $data = $this->userRepository->findUserByKey($params['q'], $params['type']);

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }

    public function listAccountOffer ()
    {
        try {
            $user_id = Auth::user()->id;
            $follower_ids = Follow::ofPluckIdUserFollowing($user_id);
            $follower_ids[] = $user_id;
            $friend_ids = Follow::ofListIdFriend($user_id);
            $datas = $this->userRepository->getListAccountOffer($follower_ids, $friend_ids);

            return [
                'code' => 200,
                'data' => $datas
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }

    public function listFollowing ($id)
    {
        try {
            $datas = $this->userRepository->find($id)->follows;
            $result = [];

            foreach ($datas as $data) {
                $result[] = $data->userFollowing;
            }

            return [
                'code' => 200,
                'data' => $result
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }

    public function getUserByNickname ($nickname)
    {
        try {
            $data = $this->userRepository->getUserByNickname($nickname);
            $data['followings_count'] = Follow::ofFollowingCount($data->id);
            $data['followers_count'] = Follow::ofFollowerCount($data->id);
            $data['likes'] = Like::ofLikesCount($data->id);

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err,
            ];
        }
    }

    public function getInfoUser ()
    {
        try {
            $data = Auth::user();

            return [
                'code' => 200,
                'data' => $data
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
     * @param $key_word
     * @return array
     */
    public function findTopUser($key_word)
    {
        try {
            $data = $this->userRepository->getTopUser($key_word);

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    public function getListFriend() {
        try {
            $users_id = $this->followRepository->getListIdFriend();
            $data = [];
            if (!empty($users_id)) {
                $data = $this->userRepository->getListUserById($users_id);
            }

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    public function getNotification() {
        try {
            $data = $this->notificationRepository->getNotification();

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    public function updateNotification() {
        try {
            $this->notificationRepository->updateNotification();

            return [
                'code' => 200,
                'message' => 'updated successfully'
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    public function getNotificationsMessages() {
        try {
            $data = $this->notificationRepository->getNotificationsMessages();

            return [
                'code' => 200,
                'data' => $data
            ];
        } catch (\Throwable $err) {
            Log::error($err);

            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    public function updateNotificationsMessage($notification_id) {
        if ( $this->notificationRepository->update($notification_id, ['checked' => 1])) {
            return [
                'code' => 200,
                'message' => 'Updated notification successfully'
            ];
        }

        return [
            'code' => 400,
            'message' => 'Update notification failed'
        ];
    }
}