<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:37 PM
 */

namespace App\Repositories;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    public function getListComment($video_id) {
        return $this->model
            ->with('user')
            ->where('video_id', $video_id)->get();
    }
}