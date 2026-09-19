<?php

namespace App\Repositories\Whatsapp\Models;

class Whatsapp
{
    public int $id;
    public ?string $message_id;
    public string $phone;
    public string $direction;
    public string $message;
    public string $source;
    public ?string $sent_at;
    public ?string $created_at;
    public ?string $updated_at;
    public ?int $messages_count;
    public ?string $last_message_at;
    public ?string $media_type;
    public ?string $media_url;
    public ?string $media_mime;
    public ?string $media_name;

    public function __construct(
        int $id,
        ?string $message_id,
        string $phone,
        string $direction,
        string $message,
        string $source,
        ?string $sent_at,
        ?string $created_at,
        ?string $updated_at,
        ?int $messages_count,
        ?string $last_message_at,
        ?string $media_type = null,
        ?string $media_url = null,
        ?string $media_mime = null,
        ?string $media_name = null,
    )
    {
        $this->id = $id;
        $this->message_id = $message_id;
        $this->phone = $phone;
        $this->direction = $direction;
        $this->message = $message;
        $this->source = $source;
        $this->sent_at = $sent_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->messages_count = $messages_count;
        $this->last_message_at = $last_message_at;
        $this->media_type = $media_type;
        $this->media_url = $media_url;
        $this->media_mime = $media_mime;
        $this->media_name = $media_name;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('Y/m/d - H:i');
    }
    public function getJalaliCreatedDate():string
    {
        return verta($this->created_at)->format('Y/m/d');
    }
    public function getJalaliUpdatedAt():string
    {
        return verta($this->updated_at)->format('Y/m/d - H:i');
    }
    public function getJalaliSentAt():?string
    {
        return isset($this->sent_at) ? verta($this->sent_at)->format('Y/m/d - H:i'):null;
    }
    public function getJalaliLastMessageAt():?string
    {
        return isset($this->last_message_at) ? verta($this->last_message_at)->format('Y/m/d - H:i'):null;
    }
    public function getSourcePersian():?string
    {
        if (isset($this->source)){
            if ($this->source === 'ai') {
                return ' - هوش مصنوعی';
            } else if ($this->source === 'admin' || $this->source === '') {
                return ' - ادمین';
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
