<?php

namespace App\Repositories\FirebaseNotification;

interface IFirebaseNotificationRepository
{
    public function send(array $userIds, string $title, string $body, ?string $url,bool $notifCreate = true):bool;
}
