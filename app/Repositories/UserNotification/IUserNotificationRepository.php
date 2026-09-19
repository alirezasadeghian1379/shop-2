<?php

namespace App\Repositories\UserNotification;

use Illuminate\Support\Collection;

interface IUserNotificationRepository
{
    public function getAllByUserId(int $userId):Collection;
    public function getAllByNotificationId(int $notificationId):Collection;
}
