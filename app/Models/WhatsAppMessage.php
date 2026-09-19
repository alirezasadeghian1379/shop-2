<?php

namespace App\Models;

use App\Enums\Gallery\StorageTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WhatsAppMessage extends Model
{
    protected $table = 'whats_app_messages';
    protected $fillable = ['message_id', 'phone', 'direction', 'message', 'source', 'media_type', 'media_mime', 'media_name', 'sent_at'];
    protected $casts = ['sent_at' => 'datetime'];

    protected $appends = ['media_url'];

    public function getMediaUrlAttribute(): ?string
    {
        return $this->media?->path ? asset('storage/'.$this->media->path) : null;
    }

    public function media(): HasOne
    {
        return $this->hasOne(Storage::class, 'item_id')
            ->where('type', StorageTypeEnum::WHATSAPP)
            ->latestOfMany();
    }
}
