<?php
namespace App\Contracts\Repositories;

interface FollowRepositoryInterface extends BaseRepositoryInterface
{
    public function findFollow($data);
    public function getFollowAlong($users_id);
    public function getListIdFriend();
}