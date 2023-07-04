<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\Admin\UserServiceInterface;
use App\Contracts\Services\Admin\VideoServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $videoService;
    private $userService;

    public function __construct(
        VideoServiceInterface $videoService,
        UserServiceInterface $userService
    )
    {
        $this->videoService = $videoService;
        $this->userService = $userService;
    }

    public function index () {
        $users = $this->userService->index();

        return view('content/dashboard/index');
    }
}
