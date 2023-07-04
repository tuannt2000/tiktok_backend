<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\Services\Api\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index () {
        $result = $this->userService->index();

        return response()->json($result, 200);
    }

    public function findUser (Request $request) {
        $params = $request->all();

        $result = $this->userService->findUserByKey($params);

        return response()->json($result, 200);
    }

    public function listAccountOffer (Request $request) {
        $result = $this->userService->listAccountOffer($request->id);

        return response()->json($result, 200);
    }

    public function listFollowing (Request $request) {
        $result = $this->userService->listFollowing($request->id);

        return response()->json($result, 200);
    }

    public function getInfoUser () {
        $result = $this->userService->getInfoUser();

        return response()->json($result, 200);
    }

    public function getUserByNickname(Request $request) {
        $result = $this->userService->getUserByNickname($request->nickname);

        return response()->json($result, 200);
    }

    /**
      * @param Request $request
      *
      * @return \Illuminate\Http\Response
     */
    public function findTopUser(Request $request) {
        $result = $this->userService->findTopUser($request->q ? urldecode($request->q) : '');

        return response()->json($result, 200);
    }

    public function listFriend () {
        $result = $this->userService->getListFriend();

        return response()->json($result, $result['code']);
    }
}
