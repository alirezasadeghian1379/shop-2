<?php

namespace App\Repositories\UserNotification;

use App\Repositories\User\Models\UserSummary;
use App\Repositories\UserNotification\Models\UserNotification;
use Illuminate\Support\Collection;
use App\Models\UserNotification as UserNotificationModel;
class UserNotificationModuleRepository implements IUserNotificationRepository
{
    public function getAllByUserId(int $userId): Collection
    {
        $userNotifications = UserNotificationModel::where('user_id',$userId)->latest()->get()->map(fn($userNotification) => new UserNotification(
            $userNotification->id,
            $userNotification->notification_id,
            $userNotification->read_at,
            $userNotification->created_at,
            $userNotification->user()->get()->map(fn($user) => new UserSummary(
                $user->id,
                $user->full_name,
                $user->phone,
                $user->roles()->exists(),
            ))->first()
        ));
        return $userNotifications;
    }

    public function getAllByNotificationId(int $notificationId): Collection
    {
        $userNotifications = UserNotificationModel::where('notification_id',$notificationId)->latest()->get()->map(fn($userNotification) => new UserNotification(
            $userNotification->id,
            $userNotification->notification_id,
            $userNotification->read_at,
            $userNotification->created_at,
            $userNotification->user()->get()->map(fn($user) => new UserSummary(
                $user->id,
                $user->full_name,
                $user->phone,
                $user->roles()->exists(),
            ))->first()
        ));
        return $userNotifications;
    }
}
