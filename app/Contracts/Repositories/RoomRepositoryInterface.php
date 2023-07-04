<?php
namespace App\Contracts\Repositories;

interface RoomRepositoryInterface extends BaseRepositoryInterface
{
    public function findRooms($user_id);
    public function findAllRooms($room_user, $user_id);
    public function createRoom($users_id);
    public function getRoomCreated($users_id);
    public function deleteRoomCreated($room_id);
    public function restoreRoomCreated($room_id);
    public function findRoomIdByUserId($user_id);
}