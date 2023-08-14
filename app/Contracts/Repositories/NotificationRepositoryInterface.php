<?php
namespace App\Contracts\Repositories;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    public function getNotification();
    public function updateNotification();
    public function getNotificationsMessages();
}