<?php
namespace App\Contracts\Repositories;

interface MessageRepositoryInterface extends BaseRepositoryInterface
{
    public function getListMessages($room_id, $users_following);
    public function store($params);
}