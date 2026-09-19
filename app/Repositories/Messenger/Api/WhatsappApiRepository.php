<?php

namespace App\Repositories\Messenger\Api;

use App\Repositories\Messenger\Contracts\IMessengerRepository;
use App\Repositories\Messenger\Model\Messenger;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\Adapters\Exception\Exception;
use Throwable;

class WhatsappApiRepository implements IMessengerRepository
{
    public function webhook(Request $request, $secret): ?Messenger
    {
        $webhookSecret = config('messenger.whatsapp.webhook_secret_key');
        abort_unless(
            is_string($webhookSecret) &&
            hash_equals($webhookSecret, $secret),
            401,
            'Invalid webhook secret'
        );

        Log::channel('messengerLog')->info('360Messenger webhook received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
        ]);

        $data = $request->validate([
            'ID' => ['required', 'string'],
            'Type' => ['required', 'string'],
            'From' => ['required', 'string'],
            'To' => ['required', 'string'],
            'Chat' => ['nullable', 'string'],
            'Caption' => ['nullable', 'string'],
            'MediaType' => ['nullable', 'in:image,video'],
            'MediaMime' => ['nullable', 'string', 'max:100'],
            'MediaName' => ['nullable', 'string', 'max:255'],
            'MediaBase64' => ['nullable', 'string'],
            'createdAt' => ['nullable', 'string'],
            'dataType' => ['required', 'string'],
            'Hash' => ['nullable', 'string'],
            'GroupId' => ['nullable', 'string'],
        ]);

        if ($data['dataType'] !== 'message') {
            return null;
        }

        if (!empty($data['GroupId'])) {
            return null;
        }

        $messageId = (string) $data['ID'];
        $messageType = (string) $data['Type'];
        $messageFrom = (string) $data['From'];
        $messageTo = (string) $data['To'];
        $messageCreatedAt = (string) $data['createdAt'];
        $message = match ($messageType) {
            'chat' => $data['Chat'] ?? null,
            'file' => $data['Caption'] ?? null,
            'location' => $data['Caption'] ?? null,
            default => null,
        };

        return new Messenger(
            $messageId,
            $messageType,
            $messageFrom,
            $messageTo,
            $message,
            $messageCreatedAt,
            $data['MediaType'] ?? null,
            $data['MediaBase64'] ?? null,
            $data['MediaMime'] ?? null,
            $data['MediaName'] ?? null,
        );
    }
    public function sendMessage(string $number, string $message,?UploadedFile $media = null): array|bool
    {
        try {
            $bridgeUrl = rtrim((string) config('messenger.whatsapp.bridge.url'), '/');
            $bridgeToken = (string) config('messenger.whatsapp.bridge.token');

            if ($bridgeUrl === '' || $bridgeToken === '') {
                throw new Exception('پیکربندی پل واتساپ ناقص است..',422);
            }

            $payload = [
                'number' => $number,
                'message' => $message,
            ];

            if ($media) {
                $mediaType = match (true) {
                    str_starts_with($media->getMimeType(), 'image/') => 'image',
                    str_starts_with($media->getMimeType(), 'video/') => 'video',
                    default => throw new Exception('فقط عکس یا ویدئو مجاز است.', 422),
                };

                $payload['media_type'] = $mediaType;
                $payload['media_mime'] = $media->getMimeType();
                $payload['media_name'] = $media->getClientOriginalName();
            }

            $request = Http::baseUrl($bridgeUrl)
                ->withToken($bridgeToken)
                ->acceptJson()
                ->connectTimeout(3)
                ->timeout(90);

            if ($media) {
                $response = $request
                    ->withQueryParameters($payload)
                    ->withBody(
                        fopen($media->getRealPath(), 'r'),
                        $payload['media_mime']
                    )
                    ->post('/whatsapp/send');
            } else {
                $response = $request->post('/whatsapp/send', $payload);
            }
            if ($response->failed()) {
                $body = $response->json();
                Log::channel('messengerLog')->error('WhatsApp Bridge send failed', [
                    'status' => $response->status(),
                    'response' => $body,
                ]);
                throw new Exception(
                    (string) ($body['message'] ?? $response->body()),
                    $response->status()
                );
            }
            $result = $response->json() ?? [];
            if ($media) {
                $result['media_type'] = $payload['media_type'];
                $result['media_mime'] = $payload['media_mime'];
                $result['media_name'] = $payload['media_name'];
            }
            return $result;
        } catch (Throwable $exception){
            $code = (int) $exception->getCode();
            throw new Exception($exception->getMessage(), $code >= 400 && $code <= 599 ? $code : 500);
        }
    }
}
