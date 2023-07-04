<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/6/2022
 * Time: 3:20 PM
 */

namespace App\Services\Api;

use App\Contracts\Repositories\FollowRepositoryInterface;
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
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        FollowRepositoryInterface $followRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->followRepository = $followRepository;
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

    public function listAccountOffer ($id)
    {
        try {
            $followerIds = Follow::ofPluckIdUserFollowing($id);
            $followerIds[] = $id;
            $datas = $this->userRepository->getListAccountOffer($followerIds);

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
}