<?php

namespace App\Contracts\Services\Api;

interface CommentServiceInterface
{
    public function store($data);
    public function delete($id);
    public function getListComment($video_id);
}