<?php

namespace App\Http\Controllers\V1\Api;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Models\WhatsAppMessage;
use App\Services\AiService;
use App\Services\Gallery\GalleryStorageService;
use App\Services\MessengerService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Throwable;
use App\Models\Setting as SettingModel;


class MessengerController extends Controller
{
    public function __construct(
        protected MessengerService $messengerService,
        protected AiService $aiService,
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService,
    ){}
    public function webhook(Request $request,$secret)
    {
        try {
            $settingCheckAiActivate = ($this->settingService->findByKey('active_ai') ?? null);
            if (isset($settingCheckAiActivate) && $settingCheckAiActivate->value == '1') {

                $webhookMessenger = $this->messengerService->webhook($request,$secret);
                if ($webhookMessenger === null || ($webhookMessenger->message === null && $webhookMessenger->media_type === null)) {
                    return Response::success([], 'پیام قابل پردازشی وجود ندارد.', 200);
                }
                $whatsappMessage = WhatsAppMessage::updateOrCreate(['message_id' => $webhookMessenger->id], [
                    'phone' => $webhookMessenger->from_number, 'direction' => 'incoming',
                    'message' => $webhookMessenger->message ?? '', 'source' => 'customer',
                    'media_type' => $webhookMessenger->media_type,
                    'media_mime' => $webhookMessenger->media_mime, 'media_name' => $webhookMessenger->media_name,
                    'sent_at' => is_numeric($webhookMessenger->created_at)
                        ? now()->setTimestamp((int) $webhookMessenger->created_at) : now(),
                ]);
                $this->storeIncomingMedia($webhookMessenger, $whatsappMessage);
                if ($webhookMessenger->message === null || trim($webhookMessenger->message) === '') {
                    return Response::success([], 'فایل با موفقیت دریافت شد.', 200);
                }
                $conversationKey = 'whatsapp_conversation_'.hash('sha256', $webhookMessenger->from_number);
                $cache = Cache::store('file');
                $history = $cache->get($conversationKey, []);
                $history = is_array($history) ? $history : [];

                $aiResult = $this->aiService->chat($webhookMessenger->message, $history);
                $aiResponse = data_get($aiResult, 'message.content');
                if (!is_string($aiResponse) || trim($aiResponse) === '') {
                    throw new \RuntimeException('AI returned an empty response.');
                }
                [$messageText, $videoFile] = $this->extractLocalVideo($aiResponse);
                if (!$videoFile && preg_match('/وید(?:ئو|یو)|video/iu', $webhookMessenger->message)) {
                    $videoFile = $this->configuredAboutVideo();
                }
                if ($videoFile) {
                    $messageText = $this->removeLinks($messageText);
                }
                $sendResult = $this->messengerService->sendMessage(
                    $webhookMessenger->from_number,
                    $messageText,
                    $videoFile
                );

                if ($sendResult === false) {
                    throw new \RuntimeException('WhatsApp failed to send the AI response.');
                }

                $aiMessage = WhatsAppMessage::create([
                    'message_id' => data_get($sendResult, 'id'),
                    'phone' => $webhookMessenger->from_number, 'direction' => 'outgoing',
                    'message' => $messageText, 'source' => 'ai',
                    'media_type' => $videoFile ? 'video' : null,
                    'media_mime' => $videoFile?->getMimeType(),
                    'media_name' => $videoFile?->getClientOriginalName(),
                    'sent_at' => now(),
                ]);
                if ($videoFile) {
                    $this->galleryStorageService->upload(
                        $videoFile,
                        'whatsapp',
                        $aiMessage->id,
                        StorageTypeEnum::WHATSAPP,
                        'video'
                    );
                }

                $history[] = ['role' => 'user', 'content' => $webhookMessenger->message];
                $history[] = ['role' => 'assistant', 'content' => $aiResponse];
                $maxMessages = max(2, (int) config('messenger.whatsapp.conversation.max_messages', 4));
                $ttlMinutes = max(1, (int) config('messenger.whatsapp.conversation.ttl_minutes', 1440));

                $cache->put(
                    $conversationKey,
                    array_slice($history, -$maxMessages),
                    now()->addMinutes($ttlMinutes)
                );


            } else {
                $webhookMessenger = $this->messengerService->webhook($request,$secret);
                if ($webhookMessenger === null || ($webhookMessenger->message === null && $webhookMessenger->media_type === null)) {
                    return Response::success([], 'پیام قابل پردازشی وجود ندارد.', 200);
                }
                $whatsappMessage = WhatsAppMessage::updateOrCreate(['message_id' => $webhookMessenger->id], [
                    'phone' => $webhookMessenger->from_number, 'direction' => 'incoming',
                    'message' => $webhookMessenger->message ?? '', 'source' => 'customer',
                    'media_type' => $webhookMessenger->media_type,
                    'media_mime' => $webhookMessenger->media_mime, 'media_name' => $webhookMessenger->media_name,
                    'sent_at' => is_numeric($webhookMessenger->created_at)
                        ? now()->setTimestamp((int) $webhookMessenger->created_at) : now(),
                ]);
                $this->storeIncomingMedia($webhookMessenger, $whatsappMessage);
            }
            return Response::success([],'عملیات با موفقیت انجام شد',200);
        } catch (Exception $exception) {
            return Response::error('error',$exception->getMessage(),$exception->getCode());
        } catch (Throwable $throwable) {
            return Response::error($throwable,$throwable->getMessage(),500);
        }
    }

    private function storeIncomingMedia(object $message, WhatsAppMessage $whatsappMessage): void
    {
        if (!$message->media_type || !$message->media_base64 || $whatsappMessage->media()->exists()) {
            return;
        }

        $contents = base64_decode($message->media_base64, true);
        if ($contents === false) {
            throw new \RuntimeException('Invalid WhatsApp media payload.');
        }

        $extension = match ($message->media_mime) {
            'image/png' => 'png', 'image/webp' => 'webp', 'video/quicktime' => 'mov',
            'video/x-msvideo' => 'avi', 'video/mp4' => 'mp4', default => 'jpg',
        };
        $temporaryPath = tempnam(sys_get_temp_dir(), 'whatsapp_');
        if ($temporaryPath === false) {
            throw new \RuntimeException('Could not create a temporary WhatsApp media file.');
        }

        try {
            if (file_put_contents($temporaryPath, $contents) === false) {
                throw new \RuntimeException('Could not prepare WhatsApp media for upload.');
            }

            $uploadedFile = new UploadedFile(
                $temporaryPath,
                $message->media_name ?: $message->id.'.'.$extension,
                $message->media_mime,
                null,
                true
            );

            $this->galleryStorageService->upload(
                $uploadedFile,
                'whatsapp',
                $whatsappMessage->id,
                StorageTypeEnum::WHATSAPP,
                $message->media_type === 'video' ? 'video' : 'image'
            );
        } finally {
            if (is_file($temporaryPath)) {
                unlink($temporaryPath);
            }
        }
    }

    /**
     * Convert a local public video URL in the AI response to an actual upload.
     * Remote URLs are deliberately ignored to prevent arbitrary server-side downloads.
     */
    private function extractLocalVideo(string $response): array
    {
        preg_match_all('~https?://[^\s<>\]"\')]+~iu', $response, $matches);
        $publicRoot = realpath(public_path());
        $storageRoot = realpath(storage_path('app/public'));

        foreach ($matches[0] ?? [] as $rawUrl) {
            $url = rtrim($rawUrl, '.,،؛;!?؟');
            $path = parse_url($url, PHP_URL_PATH);
            if (!is_string($path) || !preg_match('/\.(mp4|mov|avi|webm)$/i', $path)) {
                continue;
            }

            $decodedPath = ltrim(urldecode($path), '/');
            if (str_starts_with($decodedPath, 'storage/')) {
                $filePath = realpath(storage_path('app/public/'.substr($decodedPath, 8)));
                $allowedRoot = $storageRoot;
            } else {
                $filePath = realpath(public_path($decodedPath));
                $allowedRoot = $publicRoot;
            }
            if (!$allowedRoot || !$filePath || !str_starts_with($filePath, $allowedRoot.DIRECTORY_SEPARATOR)) {
                continue;
            }

            $size = filesize($filePath);
            if ($size === false || $size > 50 * 1024 * 1024) {
                throw new \RuntimeException('AI video exceeds the 50 MB WhatsApp limit.');
            }

            $mime = mime_content_type($filePath) ?: 'video/mp4';
            if (!str_starts_with($mime, 'video/')) {
                continue;
            }

            $caption = preg_replace(
                '~\[[^\]]*\]\(\s*'.preg_quote($url, '~').'\s*\)|'.preg_quote($url, '~').'~iu',
                '',
                $response
            );
            $caption = trim((string) preg_replace('/[ \t]+\n/', "\n", (string) $caption));

            return [
                $caption,
                new UploadedFile($filePath, basename($filePath), $mime, null, true),
            ];
        }

        return [trim($response), null];
    }

    private function configuredAboutVideo(): ?UploadedFile
    {
        $storage = SettingModel::query()
            ->where('key', 'aboutVideo')
            ->first()
            ?->aboutVideo()
            ->first();

        if (!$storage?->path) {
            return null;
        }

        $storageRoot = realpath(storage_path('app/public'));
        $filePath = realpath(storage_path('app/public/'.$storage->path));
        if (!$storageRoot || !$filePath || !str_starts_with($filePath, $storageRoot.DIRECTORY_SEPARATOR)) {
            return null;
        }

        $size = filesize($filePath);
        if ($size === false || $size > 50 * 1024 * 1024) {
            throw new \RuntimeException('Configured AI video exceeds the 50 MB WhatsApp limit.');
        }

        $mime = mime_content_type($filePath) ?: 'video/mp4';
        if (!str_starts_with($mime, 'video/')) {
            return null;
        }

        return new UploadedFile($filePath, basename($filePath), $mime, null, true);
    }

    private function removeLinks(string $message): string
    {
        $message = preg_replace('~\[([^\]]*)\]\(\s*https?://[^)]+\)~iu', '$1', $message);
        $message = preg_replace('~https?://[^\s<>]+~iu', '', (string) $message);
        $message = preg_replace('/[ \t]+\n/', "\n", (string) $message);
        $message = preg_replace('/\n{3,}/', "\n\n", (string) $message);

        return trim((string) $message);
    }
}

