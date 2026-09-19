<?php

namespace App\Services;

use App\Repositories\UserNotification\IUserNotificationRepository;
use Illuminate\Support\Collection;

class UserNotificationService
{
    public function __construct(
        protected IUserNotificationRepository $userNotification
    ){}

    public function getAllByUserId(int $userId):Collection
    {
        return $this->userNotification->getAllByUserId($userId);
    }
    public function getAllByNotificationId(int $notificationId):Collection
    {
        return $this->userNotification->getAllByNotificationId($notificationId);
    }
}
