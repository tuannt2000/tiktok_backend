<?php

namespace App\Repositories;

use App\Contracts\Repositories\FollowRepositoryInterface;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface
{
    /**
     * FollowRepository constructor.
     * @param Follow $follow
     */
    public function __construct(Follow $follow)
    {
        parent::__construct($follow);
    }

    public function findFollow($data)
    {
        return $this->model->withTrashed()
            ->where('user_id', Auth::user()->id)
            ->where('user_follower_id', $data['user_follower_id'])
            ->first();
    }

    public function getFollowAlong($users_id)
    {
        return $this->model
            ->whereIn('user_id', $users_id)
            ->whereIn('user_follower_id', $users_id)
            ->get();
    }

    public function getListIdFriend() {
        $query = DB::table('follows AS f1')
            ->join('follows AS f2', function ($query) {
                return $query->on('f2.user_follower_id', '=', 'f1.user_id')
                    ->on('f2.user_id', '=', 'f1.user_follower_id');
            })
            ->where('f1.user_id', Auth::user()->id)
            ->whereNull('f1.deleted_at')
            ->whereNull('f2.deleted_at')
            ->pluck('f1.user_follower_id')
            ->toArray();

        return $query;
    }
}