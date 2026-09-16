<?php

namespace App\Repositories\Gallery\Models;

class GalleryDb
{
    public int $id;
    public string $uuid;
    public string $type;
    public string $path;
    public int $item_id;
    public bool $registered;
    public string $created_at;
    public string $updated_at;
    public function __construct(
        int $id,
        string $uuid,
        string $type,
        string $path,
        int $item_id,
        bool $registered,
        string $created_at,
        string $updated_at
    )
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->type = $type;
        $this->path = $path;
        $this->item_id = $item_id;
        $this->registered = $registered;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
    public function getJalaliUpdatedAt():string
    {
        return verta($this->updated_at)->format('%d %B Y ( H:i )');
    }
}
