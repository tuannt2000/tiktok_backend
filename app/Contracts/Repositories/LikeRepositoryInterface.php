<?php
namespace App\Contracts\Repositories;

interface LikeRepositoryInterface extends BaseRepositoryInterface
{
    public function findVideo($data);
}