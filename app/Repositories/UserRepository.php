<?php
namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getAll()
    {
        return $this->model
                    ->select('users.*', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"))
                    ->get();
    }

    public function findUserByKey($q, $type)
    {
        $query = $this->model
                ->select('users.*', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"))
                ->where('nickname', 'like', '%'.$q.'%');

        if ($type == 'less') {
            $query->take(5);
        }

        if (Auth::check()) {
            $query->where('id', '!=', Auth::user()->id);
        }

        return $query->get();
    }

    public function getListAccountOffer ($follower_ids, $friend_ids)
    {
        return $this->model
            ->select(
                'users.*',
                DB::raw('Count(f1.user_follower_id) as mutual_friend_count')
            )
            ->leftJoin('follows AS f1', function ($join) use($friend_ids) {
                $join->on('f1.user_follower_id', '=', 'users.id')
                    ->join('follows AS f2', function ($query) {
                        $query->on('f1.user_id', '=', 'f2.user_follower_id')
                            ->on('f1.user_follower_id', '=', 'f2.user_id');
                    })
                    ->whereIn('f1.user_id', $friend_ids);
            })
            ->withCount(['likes', 'followers'])
            ->whereNotIn('users.id', $follower_ids)
            ->groupBy('f1.user_follower_id')
            ->orderBy('mutual_friend_count', 'desc')
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();
    }

    public function getUserByNickname ($nickname)
    {
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $select_add = '(CASE WHEN follows.user_follower_id IS NULL THEN False ELSE True END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }

        return $this->model
            ->select(
                'users.*',
                DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"),
                DB::raw($select_add)
            )
            ->when($user_id, function ($query) use ($user_id) {
                $query->leftJoin('follows', function ($join) use ($user_id) {
                        $join->on('follows.user_follower_id', '=', 'users.id')
                            ->where('follows.user_id', $user_id)
                            ->whereNull('follows.deleted_at');
                    });
            })
            ->where('nickname', $nickname)
            ->first();
    }

    public function getTopUser ($key_word) {
        $video = $this->model
            ->withCount('follows')
            ->where(function ($query) use($key_word) {
                $query->where('nickname', 'like', '%' . $key_word . '%')
                      ->orWhere('first_name', 'like', '%' . $key_word . '%')
                      ->orWhere('last_name', 'like', '%' . $key_word . '%')
                      ->orWhere('bio', 'like', '%' . $key_word . '%');
            })
            ->orderBy('follows_count', 'DESC')
            ->take(15)
            ->get();

        return $video;
    }

    public function getAllUserFullInfo()
    {
        return $this->model
            ->select('users.*')
            ->where('users.role', 'USER')
            ->withCount(['follows', 'followers'])
            ->get();
    }

    public function getListUserById($users_id) {
        return $this->model
            ->select('users.*', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"))
            ->whereIn('id', $users_id)
            ->get();
    }
}