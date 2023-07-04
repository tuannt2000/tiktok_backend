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

    public function getListAccountOffer ($followerIds)
    {
        return $this->model
            ->withCount(['likes', 'followers'])
            ->whereNotIn('users.id', $followerIds)
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();
    }

    public function getUserByNickname ($nickname)
    {
        return $this->model
            ->select('users.*', DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"))
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