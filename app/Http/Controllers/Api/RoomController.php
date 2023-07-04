<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\RoomServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $roomService;
    protected $notificationService;

    public function __construct(RoomServiceInterface $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index (Request $request) {
        $result = $this->roomService->index($request->user_id);

        return response()->json($result, 200);
    }

    public function removeNotification (Request $request) {
        $result = $this->roomService->removeNotification($request->notification_id);

        return response()->json($result, 200);
    }
}
