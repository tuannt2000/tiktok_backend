<?php
namespace App\Contracts\Repositories;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getListComment($video_id);
}