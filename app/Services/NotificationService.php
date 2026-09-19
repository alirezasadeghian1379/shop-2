<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Notification\INotificationRepository;
use App\Repositories\Notification\Models\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
    public function __construct(
        protected INotificationRepository $notification
    ){}

    public function all():Collection
    {
        return $this->notification->all();
    }

    public function paginate(int $perPage):PaginatorAdapter
    {
        return $this->notification->paginate($perPage);
    }

    public function findById(int $id):Notification
    {
        return $this->notification->findById($id);
    }
    public function create(array $data):Notification
    {
        return $this->notification->create($data);
    }
    public function update(int $id,array $data):bool
    {
        return $this->notification->update($id,$data);
    }
    public function destroy(int $id):bool
    {
        return $this->notification->destroy($id);
    }
    public function getNotificationByUserId(int $userId):Collection
    {
        return $this->notification->getNotificationByUserId($userId);
    }
    public function markAllNotificationsAsReadForUser(int $userId):bool
    {
        return $this->notification->markAllNotificationsAsReadForUser($userId);
    }
    public function getNotificationCountByUserId(int $userId):int
    {
        return $this->notification->getNotificationCountByUserId($userId);
    }
    public function destroyAll(array $ids):int
    {
        return $this->notification->destroyAll($ids);
    }
}
