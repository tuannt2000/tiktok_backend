<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:34 PM
 */

namespace App\Services\Api;

use App\Contracts\Services\Api\MessageServiceInterface;
use App\Contracts\Repositories\MessageRepositoryInterface;
use App\Models\Follow;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageService extends AbstractService implements MessageServiceInterface
{
    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * MessageService constructor.
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param $room_id
     * @return array
     */
    public function index($room_id)
    {
        try {
            $users_following = Follow::ofPluckIdUserFollowing(Auth::user()->id);
            
            return [
                'code' => 200,
                'data' => $this->messageRepository->getListMessages($room_id, $users_following)
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
    public function store($params)
    {
        try {
            $messageStore = $this->messageRepository->store($params);
            return [
                'code' => 200,
                'data' =>  $messageStore,
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return response()->json([
                'code' => 400,
                'message' => $err
            ]);
        }
    }
}