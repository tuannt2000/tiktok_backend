<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\Admin\VideoServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    private $videoService;

    public function __construct(
        VideoServiceInterface $videoService
    )
    {
        $this->videoService    = $videoService;
    }

    public function index () {
        $videos = $this->videoService->index();

        return view('content.videos.index', compact('videos'));
    }
}
