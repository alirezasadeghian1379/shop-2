<?php

namespace App\Repositories\User\Models;

use App\Repositories\Gallery\Models\GalleryDb;

class User
{
    public int $id;
    public ?string $first_name;
    public ?string $last_name;
    public string $phone;
    public bool $active;

    public ?string $role_type;
    public ?string $email;
    public string $created_at;
    public string $updated_at;

    /** @var GalleryDb|GalleryDb[]|null */
    public $avatar = null;

    public function __construct(
        int $id,
        ?string $first_name,
        ?string $last_name,
        string $phone,
        bool $active,
        ?string $role_type,
        ?string $email,
        string $created_at,
        string $updated_at,
        $avatar = null,
    )
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->active = $active;
        $this->role_type = $role_type;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->avatar = $avatar;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getJalaliCreatedAt()
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
    public function getJalaliUpdatedAt()
    {
        return verta($this->updated_at)->format('%d %B Y ( H:i )');
    }
    public function getAvatarExists(): bool
    {
        return !empty($this->avatar);
    }
    public function getAvatarUrl(): ?string
    {
        return $this->getAvatarExists() ? asset('storage/' . $this->avatar->path):null;
    }
}
