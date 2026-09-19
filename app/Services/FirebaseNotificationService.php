<?php

namespace App\Services;

use App\Repositories\FirebaseNotification\IFirebaseNotificationRepository;

class FirebaseNotificationService
{
    public function __construct(
        protected IFirebaseNotificationRepository $firebaseNotificationRepository,
    ){}
    public function send(array $userIds, string $title, string $body, ?string $url,bool $notifCreate = true):bool
    {
        return $this->firebaseNotificationRepository->send($userIds, $title, $body, $url, $notifCreate);
    }
}
