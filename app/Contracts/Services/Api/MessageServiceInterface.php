<?php

namespace App\Contracts\Services\Api;

interface MessageServiceInterface
{
    public function index($room_id);
    public function store($params);
}