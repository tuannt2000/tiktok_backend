<?php

namespace App\Contracts\Services\Api;

interface UserServiceInterface
{
    public function index();
    public function findUserByKey($params);
    public function listAccountOffer($id);
    public function listFollowing($id);
    public function getUserByNickname ($nickname);
    public function getInfoUser();
    public function findTopUser($key_word);
    public function getListFriend();
}