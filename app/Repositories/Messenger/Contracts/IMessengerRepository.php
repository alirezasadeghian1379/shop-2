<?php

namespace App\Repositories\Messenger\Contracts;

use App\Repositories\Messenger\Model\Messenger;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

interface IMessengerRepository
{
    public function webhook(Request $request,$secret): ?Messenger;
    public function sendMessage(string $number, string $message,?UploadedFile $media = null): array|bool;
}
