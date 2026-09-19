<?php

namespace App\Repositories\Notification;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Notification\Models\Notification;
use Illuminate\Support\Collection;

interface INotificationRepository
{
    public function all():Collection;
    public function paginate(int $perPage):PaginatorAdapter;
    public function findById(int $id):Notification;
    public function create(array $data):Notification;
    public function update(int $id,array $data):bool;
    public function destroy(int $id):bool;
    public function getNotificationCountByUserId(int $userId):int;
    public function getNotificationByUserId(int $userId):Collection;
    public function markAllNotificationsAsReadForUser(int $userId):bool;
    public function destroyAll(array $ids):bool;
}
