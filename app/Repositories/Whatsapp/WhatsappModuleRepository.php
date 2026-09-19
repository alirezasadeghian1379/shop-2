<?php

namespace App\Repositories\Whatsapp;

use App\Repositories\Whatsapp\Models\Whatsapp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\WhatsAppMessage as WhatsAppMessageModel;

class WhatsappModuleRepository implements IWhatsappRepository
{
    public function getAll(): Collection
    {
        $table = (new WhatsAppMessageModel())->getTable();

        return WhatsAppMessageModel::query()
            ->with('media')
            ->from("$table as w")
            ->whereRaw("
                w.id = (
                    SELECT w2.id
                    FROM $table as w2
                    WHERE w2.phone = w.phone
                    ORDER BY COALESCE(w2.sent_at, w2.created_at) DESC, w2.id DESC
                    LIMIT 1
                )
            ")
            ->select('w.*')
            ->selectRaw('COALESCE(w.sent_at, w.created_at) as last_message_at')
            ->selectSub(
                DB::table("$table as c")
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('c.phone', 'w.phone'),
                'messages_count'
            )
            ->orderByDesc('last_message_at')
            ->get()
            ->map(fn (WhatsAppMessageModel $item) => new Whatsapp(
                $item->id,
                $item->message_id,
                $item->phone,
                $item->direction,
                $item->message,
                $item->source,
                $item->sent_at,
                $item->created_at,
                $item->updated_at,
                $item->messages_count,
                $item->last_message_at,
                $item->media_type,
                $item->media_url,
                $item->media_mime,
                $item->media_name,
            ));
    }

    public function messagesFor(string $phone): Collection
    {
        return WhatsAppMessageModel::query()->with('media')->where('phone', $phone)
            ->orderBy('created_at')->orderBy('id')->limit(500)->get()->map(fn($item) => new Whatsapp(
                $item->id,
                $item->message_id,
                $item->phone,
                $item->direction,
                $item->message,
                $item->source,
                $item->sent_at,
                $item->created_at,
                $item->updated_at,
                $item->messages_count,
                $item->last_message_at,
                $item->media_type,
                $item->media_url,
                $item->media_mime,
                $item->media_name
            ));
    }

    public function store(string $messageId,array $data): Whatsapp
    {
        $message = WhatsAppMessageModel::create([
            'message_id' => $messageId !== '' ? $messageId : null,
            'phone' => $data['phone'],
            'direction' => 'outgoing',
            'message' => $data['message'] ?? '',
            'source' => 'admin',
            'media_type' => $data['media_type'] ?? null,
            'media_mime' => $data['media_mime'] ?? null,
            'media_name' => $data['media_name'] ?? null,
            'sent_at' => now(),
        ]);
        return new Whatsapp(
            $message->id,
            $message->message_id,
            $message->phone,
            $message->direction,
            $message->message,
            $message->source,
            $message->sent_at,
            $message->created_at,
            $message->updated_at,
            $message->messages_count,
            $message->last_message_at,
            $message->media_type,
            $message->media_url,
            $message->media_mime,
            $message->media_name,
        );
    }

    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($phone, '00')) {
            return substr($phone, 2);
        }
        if (str_starts_with($phone, '0')) {
            return '98'.substr($phone, 1);
        }
        return $phone;
    }
}
