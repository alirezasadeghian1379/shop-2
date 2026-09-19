<?php

namespace App\Services;

use App\Repositories\Messenger\Factories\MessengerFactoryRepository;
use App\Repositories\Messenger\Model\Messenger;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MessengerService
{
    protected $repo;
    public function __construct(?string $messengerType)
    {
        $this->repo = MessengerFactoryRepository::make(isset($messengerType) ? $messengerType:null);
    }

    public function webhook(Request $request, string $secret): ?Messenger
    {
        return $this->repo->webhook($request,$secret);
    }
    public function sendMessage(string $number, string $message,?UploadedFile $media = null): array|bool
    {
        return $this->repo->sendMessage($number, $message,$media);
    }
}
