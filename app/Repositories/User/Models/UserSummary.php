<?php

namespace App\Repositories\User\Models;

use App\Repositories\Gallery\Models\GalleryDb;

class UserSummary
{
    public int $id;
    public ?string $full_name;
    public string $phone;
    public bool $is_admin;

    /** @var GalleryDb|GalleryDb[]|null */
    public $image = null;

    public function __construct(int $id, ?string $full_name, string $phone, bool $is_admin,$image = null)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->phone = $phone;
        $this->is_admin = $is_admin;
        $this->image = $image;
    }

    public function getImageExists():bool
    {
        return isset($this->image);
    }
    public function getImageUrl():?string
    {
        return $this->getImageExists() ? asset('storage/'.$this->image->path):null;
    }
}
