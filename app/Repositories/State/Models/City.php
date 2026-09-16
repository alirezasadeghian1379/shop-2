<?php

namespace App\Repositories\State\Models;

use App\Repositories\State\Models\Province;

class City
{
    public int $id;
    public string $name;
    public string $slug;
    public ?string $latitude;
    public ?string $longitude;
    public bool $is_active;
    public string $created_at;

    /** @var Province|Province[]|null */
    public $province = null;

    public function __construct(
        int $id,
        string $name,
        string $slug,
        ?string $latitude,
        ?string $longitude,
        bool $is_active,
        string $created_at,
        $province = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->province = $province;
    }

    public function getJalaliCreatedAt(): string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
}
