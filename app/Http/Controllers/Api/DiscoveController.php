<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\MusicServiceInterface;
use App\Contracts\Services\Api\TagServiceInterface;
use App\Http\Controllers\Controller;

class DiscoveController extends Controller
{
    protected $musicService;
    protected $tagService;

    public function __construct(MusicServiceInterface $musicService, TagServiceInterface $tagService)
    {
        $this->musicService = $musicService;
        $this->tagService = $tagService;
    }

    public function index () {
        $music = $this->musicService->index()['data'];
        $tag = $this->tagService->index()['data'];

        $discove = $music->unionAll($tag)->orderBy('uses_count', 'DESC')->take(10)->get();

        $result = [
            'code' => 200,
            'data' => $discove
        ];

        return response()->json($result, 200);
    }
}
