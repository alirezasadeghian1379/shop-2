<?php

namespace App\Repositories\Slider\Models;


use App\Repositories\Gallery\Models\GalleryDb;

class Slider
{
    public int $id;
    public string $title;
    public ?string $description;
    public string|null $link;
    public bool $active;
    public string $expired_at;
    public string $created_at;

    /** @var GalleryDb|GalleryDb[]|null */
    public $image = null;

    public function __construct(
        int $id,
        string $title,
        ?string $description,
        string|null $link,
        bool $active,
        string $expired_at,
        string $created_at,
        $image = null,
        )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
        $this->active = $active;
        $this->expired_at = $expired_at;
        $this->created_at = $created_at;
        $this->image = $image;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
    public function getJalaliExpiredAt():string
    {
        return verta($this->expired_at)->format('%d %B Y ( H:i )');
    }
    public function getExpiredAt():string
    {
        return verta($this->expired_at)->format('Y/m/d H:i:s');
    }
    public function getImageExists():bool
    {
        return isset($this->image);
    }
    public function getImageUrl():string|null
    {
        return $this->getImageExists() ? asset('storage/'.$this->image->path):null;
    }
}
