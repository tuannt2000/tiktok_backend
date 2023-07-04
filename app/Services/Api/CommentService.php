<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/8/2022
 * Time: 3:34 PM
 */

namespace App\Services\Api;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Video;
use App\Services\AbstractService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentService extends AbstractService implements CommentServiceInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store($data)
    {
        try {
            $video = Video::where([
                'id' => $data['video_id']
            ])->first();

            if ($video->comment == 0) {
                throw new \Exception("Video can't comment");
            }

            $data['user_id'] = Auth::user()->id;
            $data['date_comment'] = Carbon::now();
            $this->commentRepository->create($data);

            return [
                'code' => 200,
                'message' => "Đăng comment thành công"
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

     /**
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        try {
            $comment = Comment::findOrFail($id);

            if ($comment->user_id != Auth::user()->id) {
                throw new \Exception("Comment can't delete");
            }
            
            $this->commentRepository->delete($id);

            return [
                'code' => 200,
                'message' => "Xóa comment thành công"
            ];
        } catch (\Throwable $err) {
            Log::error($err);
            
            return [
                'code' => 400,
                'message' => $err->getMessage()
            ];
        }
    }

    /**
     * @param int $video_id
     * @return array
     */
    public function getListComment($video_id) {
        try {
            $data = $this->commentRepository->getListComment($video_id);

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