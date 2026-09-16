<?php

namespace App\Repositories\State\Models;

use App\Repositories\State\Models\City;

class Province
{
    public int $id;
    public string $name;
    public string $slug;
    public ?string $latitude;
    public ?string $longitude;
    public bool $is_active;
    public string $created_at;

    /** @var City|City[]|null */

    public $cities = null;
    public function __construct(
        int $id,
        string $name,
        string $slug,
        ?string $latitude,
        ?string $longitude,
        bool $is_active,
        string $created_at,
        $cities = null
    ){
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->cities = $cities;
    }

    public function getJalaliCreatedAt():string
    {
        return verta($this->created_at)->format('%d %B Y ( H:i )');
    }
}
