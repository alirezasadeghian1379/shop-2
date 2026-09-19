<?php

namespace App\Repositories\Notification;

use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Notification\Models\Notification;
use App\Repositories\User\Models\UserSummary;
use Illuminate\Support\Collection;
use App\Models\Notification as NotificationModel;
use App\Models\UserNotification as UserNotificationModel;
use App\Models\User as UserModel;

class NotificationModuleRepository implements INotificationRepository
{

    public function all(): Collection
    {
        $notifications = NotificationModel::latest()->get()->map(fn($notification) => new Notification(
            $notification->id,
            $notification->title,
            $notification->message,
            $notification->type,
            $notification->url,
            $notification->is_global,
            $notification->created_at,
            $notification->users()->get()->map(fn($user) => new UserSummary(
                $user->id,
                $user->full_name,
                $user->phone,
                $user->roles()->exists(),
            ))->toArray()
        ));
        return $notifications;
    }

    public function paginate(int $perPage): PaginatorAdapter
    {
        $notifications = NotificationModel::latest()->paginate($perPage);
        $notifications->setCollection(
            $notifications->getCollection()->map(fn($notification) => new Notification(
                $notification->id,
                $notification->title,
                $notification->message,
                $notification->type,
                $notification->url,
                $notification->is_global,
                $notification->created_at,
                $notification->users()->get()->map(fn($user) => new UserSummary(
                    $user->id,
                    $user->full_name,
                    $user->phone,
                    $user->roles()->exists(),
                ))->toArray()
            ))
        );
        return new EloquentPaginatorAdapter($notifications);
    }

    public function findById(int $id): Notification
    {
        $notification = NotificationModel::where('id', $id)->first();
        if (!$notification) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Notification(
            $notification->id,
            $notification->title,
            $notification->message,
            $notification->type,
            $notification->url,
            $notification->is_global,
            $notification->created_at,
            $notification->users()->get()->map(fn($user) => new UserSummary(
                $user->id,
                $user->full_name,
                $user->phone,
                $user->roles()->exists(),
            ))->toArray()
        );
    }

    public function create(array $data): Notification
    {
        $newNotification = NotificationModel::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'],
            'url' => isset($data['url']) ? $data['url'] : null,
            'is_global' => isset($data['is_global']) && $data['is_global'] == 'on' ? 1 : 0,
        ]);
        if (isset($data['user_ids'])){
            foreach ($data['user_ids'] as $user_id) {
                UserNotificationModel::create([
                    'user_id' => $user_id,
                    'notification_id' => $newNotification->id,
                ]);
            }
        }
        return new Notification(
            $newNotification->id,
            $newNotification->title,
            $newNotification->message,
            $newNotification->type,
            $newNotification->url,
            $newNotification->is_global,
            $newNotification->created_at,
            $newNotification->users()->get()->map(fn($user) => new UserSummary(
                $user->id,
                $user->full_name,
                $user->phone,
                $user->roles()->exists(),
            ))->toArray()
        );
    }

    public function update(int $id, array $data): bool
    {
        $notification = NotificationModel::where('id', $id)->first();
        if (!$notification) throw new Exception('اطلاعاتی یافت نشد!',404);
        $notification->update([
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'],
            'url' => isset($data['url']) ? $data['url'] : null,
            'is_global' => isset($data['is_global']) && $data['is_global'] == 'on' ? 1 : 0,
        ]);
        return true;
    }

    public function destroy(int $id): bool
    {
        $notification = NotificationModel::where('id', $id)->first();
        if (!$notification) throw new Exception('اطلاعاتی یافت نشد!',404);
        $notification->delete();
        return true;
    }

    public function getNotificationCountByUserId(int $userId): int
    {
        $notificationCount = NotificationModel::whereHas('userNotifications', function ($q) use ($userId) {
            $q->where('user_id', $userId)
                ->whereNull('read_at');
        })->count();
        return $notificationCount;
    }
    public function getNotificationByUserId(int $userId): Collection
    {
        $user = UserModel::where('id',$userId)->first();
        if (!$user) throw new Exception('اطلاعاتی یافت نشد',404);
        $notifications = NotificationModel::with('users', 'userNotifications')
            ->where(function ($query) use ($user) {
                $query->where('is_global', false)
                ->where('created_at', '>=', $user->created_at)
                ->orWhereHas('userNotifications', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->latest()
            ->get()
            ->map(fn($notification) => new Notification(
                $notification->id,
                $notification->title,
                $notification->message,
                $notification->type,
                $notification->url,
                $notification->is_global,
                $notification->created_at,
                $notification->users->map(fn($user) => new UserSummary(
                    $user->id,
                    $user->full_name,
                    $user->phone,
                    $user->roles->isNotEmpty(),
                ))->toArray()
            ));
        return $notifications;
    }
    public function markAllNotificationsAsReadForUser(int $userId): bool
    {
        $notificationIds = NotificationModel::where('is_global', false)
            ->orWhereHas('userNotifications', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->latest()->pluck('id')->toArray();
        UserNotificationModel::where('user_id',$userId)->whereIn('notification_id', $notificationIds)->update(['read_at' => now()]);
         return true;
    }

    public function destroyAll(array $ids):bool
    {
        NotificationModel::whereIn('id', $ids)->delete();
        return true;
    }
}
