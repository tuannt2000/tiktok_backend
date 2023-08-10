<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VideoRepository extends BaseRepository implements VideoRepositoryInterface
{
    /**
     * VideoRepository constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        parent::__construct($video);
    }

    public function index($users_friend, $users_following, $offset) {
        $query = $this->__getQueryListVideo();
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }
        $video = $query
            ->addSelect(DB::raw($select_add))
            ->where(function ($query) use($users_friend) {
                $query->where('status', 0)
                    ->orWhere(function ($query) use($users_friend) {
                        $query->whereIn('user_id', $users_friend)
                            ->where('status', 1);
                    });
            })
            ->where('user_id', '<>', Auth::user()->id)
            ->orderByDesc('created_at')
            ->skip($offset)
            ->take(5)
            ->get();

        return $video;
    }

    public function getVideoById($id, $users_following) {
        $query = $this->__getQueryListVideo();
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }
        $video = $query
            ->with('user')
            ->addSelect(DB::raw($select_add))
            ->where('id', $id)
            ->first();

        return $video;
    }

    public function getVideoNotLogin() {
        $query = $this->__getQueryListVideo();
        $video = $query
            ->where('status', 0)
            ->orderByDesc('created_at')
            ->take(15)
            ->get();

        return $video;
    }

    public function getAll() {
        $videos = $this->model->join('users', 'users.id', '=', 'videos.user_id')
            ->where('users.role', 'USER')
            ->withCount(['likes' => function($query) {
                $query->whereNull('deleted_at');
            }])
            ->get();

        return $videos;
    }

    public function videoFollowing($users_friend, $users_following, $offset) {
        $query = $this->__getQueryListVideo();
        if (!empty($users_following)) {
            $select_following = implode(', ', $users_following);
            $select_add = '(CASE WHEN user_id IN (' . $select_following . ') THEN True ELSE False END) AS is_user_following';
        } else {
            $select_add = 'false AS is_user_following';
        }
        $video = $query
            ->addSelect(DB::raw($select_add))
            ->where(function ($query) use($users_friend, $users_following) {
                $query->where(function ($query) use($users_friend) {
                    $query->whereIn('user_id', $users_friend)
                    ->where('status', '<>', 2);
                })->orWhere(function ($query) use($users_following) {
                    $query->whereIn('user_id', $users_following)
                        ->where('status', 0);
                });
            })
            ->orderByDesc('created_at')
            ->skip($offset)
            ->take(5)
            ->get();

        return $video;
    }

    public function getMyVideo($id, $is_friend) {
        $user_id = Auth::check() ? Auth::user()->id : null;
        $query = $this->__getQueryListVideo();
        if ($user_id) {
            $query = $query->with(['following' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }]);
        }
        if ($is_friend) {
            $query = $query->where('videos.status', '<>', 2);
        } else if ($user_id != $id) {
            $query = $query->where('videos.status', 0);
        }
        $video = $query
            ->where('videos.user_id', $id)
            ->get();

        return $video;
    }

    public function getMyVideoLike($users_friend) {
        $user_id = Auth::check() ? Auth::user()->id : null;
        $query = $this->__getQueryListVideo();
        $video = $query
            ->where(function ($query) use($users_friend) {
                $query->where('status', 0)
                    ->orWhere(function ($query) use($users_friend) {
                    $query->whereIn('videos.user_id', $users_friend)
                        ->where('status', 1);
                    });
            })
            ->where('videos.user_id', '<>', $user_id)
            ->join('likes', 'likes.video_id', '=', 'videos.id')
            ->where('likes.user_id', $user_id)
            ->whereNull('likes.deleted_at')
            ->get();

        return $video;
    }

    public function uploadVideo($data)
    {
        $data['user_id'] = Auth::user()->id;
        $data['date_upload'] = Carbon::now();
        $this->model::create($data);
    }

    public function getTopVideo($key_word) {
        $video = $this->model
            ->with('user')
            ->withCount('likes')
            ->where('description', 'like', '%' . $key_word . '%')
            ->orderBy('likes_count', 'DESC')
            ->take(15)
            ->get();

        return $video;
    }

    private function __getQueryListVideo () {
        $query = $this->model
            ->with(['user' => function($query) { 
                $query->withCount([
                    'followers', 
                    'likes'
                ]);
            }])
            ->with(['likes' => function($query) {
                $query->where('likes.user_id', Auth::check() ? Auth::user()->id : 0)
                    ->whereNull('deleted_at');
            }])
            ->withCount(['likes' => function($query) {
                $query->whereNull('deleted_at');
            }])
            ->withCount(['comments', 'shares']);

        return $query;
    }
}