<?php
namespace App\Repositories\Setting\Models;


use App\Repositories\Gallery\Models\GalleryDb;

class Setting
{
    public int $id;
    public string $key;
    public ?string $value;

    /** @var GalleryDb|GalleryDb[]|null */
    public $logo = null;

    /** @var GalleryDb|GalleryDb[]|null */
    public $icon = null;
    /** @var GalleryDb|GalleryDb[]|null */
    public $watermark = null;

    public function __construct(
        int $id,
        string $key,
        ?string $value,
        $logo = null,
        $icon = null,
        $watermark = null,
    )
    {
        $this->id = $id;
        $this->key = $key;
        $this->value = $value;
        $this->logo = $logo;
        $this->icon = $icon;
        $this->watermark = $watermark;
    }
}
