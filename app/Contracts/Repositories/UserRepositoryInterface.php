<?php
namespace App\Contracts\Repositories;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll();
    public function findUserByKey($q, $type);
    public function getListAccountOffer($id);
    public function getUserByNickname ($nickname);
    public function getTopUser ($key_word);
    public function getAllUserFullInfo();
    public function getListUserById($users_id);
}