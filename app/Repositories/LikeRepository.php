<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\LikeRepositoryInterface;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    /**
     * TagRepository constructor.
     * @param Like $like
     */
    public function __construct(Like $like)
    {
        parent::__construct($like);
    }

    
    public function findVideo($data)
    {
        $video_id = $data['video_id'];

        return $this->model
            ->withTrashed()
            ->where('video_id', $video_id)
            ->where('user_id', Auth::user()->id)
            ->first();
    }
}