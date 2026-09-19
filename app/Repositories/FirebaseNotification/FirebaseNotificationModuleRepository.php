<?php

namespace App\Repositories\FirebaseNotification;

use App\Enums\Notification\NotificationTypeEnum;
use App\Models\User as UserModel;
use App\Services\NotificationService;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Throwable;

class FirebaseNotificationModuleRepository implements IFirebaseNotificationRepository
{

    public function send(array $userIds, string $title, string $body, ?string $url, bool $notifCreate = true): bool
    {
        $authUrl = config('firebase.auth_url');
        $sendUrl = config('firebase.send_url');

        if (count($userIds) == 0) {
            $users = UserModel::with(['roles','avatar'])
                ->where('active',1)
                ->latest()
                ->get();
        } else {
            $users = UserModel::whereIn('id',$userIds)
                ->with(['roles','avatar'])
                ->where('active',1)
                ->latest()
                ->get();
        }

        if ($notifCreate){
            $notificationService = app(NotificationService::class);
            $notificationService->create([
                'title' => $title,
                'message' => $body,
                'type' => NotificationTypeEnum::SUCCESS,
                'url' => $url,
                'is_global' => count($userIds) == 0 ? 0 : 1,
                'user_ids' => $userIds,
            ]);
        }

        $tokens = collect($users)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        if (empty($tokens)) return false;
        $serviceAccountPath = storage_path(config('firebase.credentials'));
        try {
            $credentials = new ServiceAccountCredentials($authUrl, $serviceAccountPath);
            $accessToken = $credentials->fetchAuthToken()['access_token'];
        } catch (\Exception $e) {
            return false;
        }
        $projectId = config('firebase.project_id');
        $siteLogo = asset('/images/logo.png');
        foreach ($tokens as $token) {
            $message = [
                "message" => [
                    "token" => $token,
                    "data" => [
                        "title" => $title,
                        "body" => $body,
                        "icon" => $siteLogo,
                        "click_action" => $url
                    ]
                ],
            ];
            try {
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post($sendUrl.$projectId.'/messages:send', $message);
            } catch (Throwable $exception){}
        }
        return true;
    }
}
