<?php

namespace App\Contracts\Services\Api;

interface UserServiceInterface
{
    public function index();
    public function findUserByKey($params);
    public function listAccountOffer();
    public function listFollowing($id);
    public function getUserByNickname ($nickname);
    public function getInfoUser();
    public function findTopUser($key_word);
    public function getListFriend();
    public function getNotification();
    public function updateNotification();
    public function getNotificationsMessages();
    public function updateNotificationsMessage($notification_id);
}