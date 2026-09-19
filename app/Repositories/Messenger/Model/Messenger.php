<?php

namespace App\Repositories\Messenger\Model;

class Messenger
{
    public string $id;
    public string $type;
    public string $from_number;
    public string $to_number;
    public ?string $message;
    public ?string $created_at;
    public ?string $media_type;
    public ?string $media_base64;
    public ?string $media_mime;
    public ?string $media_name;

    public function __construct(
        string $id,
        string $type,
        string $from_number,
        string $to_number,
        ?string $message,
        ?string $created_at,
        ?string $media_type = null,
        ?string $media_base64 = null,
        ?string $media_mime = null,
        ?string $media_name = null,
    )
    {
        $this->id = $id;
        $this->type = $type;
        $this->from_number = $from_number;
        $this->to_number = $to_number;
        $this->message = $message;
        $this->created_at = $created_at;
        $this->media_type = $media_type;
        $this->media_base64 = $media_base64;
        $this->media_mime = $media_mime;
        $this->media_name = $media_name;
    }
}
