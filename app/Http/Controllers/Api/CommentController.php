<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\CommentStoreRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store (CommentStoreRequest $request) {
        $result = $this->commentService->store($request->all());

        return response()->json($result, $result['code']);
    }

    public function delete (Request $request) {
        $result = $this->commentService->delete($request->id);

        return response()->json($result, $result['code']);
    }

    public function getListComment ($video_id = null) {
        $result = $this->commentService->getListComment($video_id);

        return response()->json($result, 200);
    }
}
