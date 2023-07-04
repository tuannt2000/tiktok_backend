<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\FollowServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowServiceInterface $followService)
    {
        $this->followService = $followService;
    }

    public function store (Request $request) {
        $result = $this->followService->store($request->all());

        return response()->json($result, 200);
    }
}
