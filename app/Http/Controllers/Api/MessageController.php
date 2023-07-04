<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\MessageServiceInterface;
use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService = $messageService;
    }

     /**
     * @param Request $request
     */
    public function index (Request $request) {
        $result = $this->messageService->index($request->room_id);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $params = $request->all();
        $params['date_send'] = Carbon::now();
        $result = $this->messageService->store($params);
        event(new MessageEvent($params));

        return response()->json($result, 200);
    }
}
