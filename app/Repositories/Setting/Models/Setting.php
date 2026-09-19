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
    /** @var GalleryDb|GalleryDb[]|null */
    public $about_image = null;

    public function __construct(
        int $id,
        string $key,
        ?string $value,
        $logo = null,
        $icon = null,
        $watermark = null,
        $about_image = null,
    )
    {
        $this->id = $id;
        $this->key = $key;
        $this->value = $value;
        $this->logo = $logo;
        $this->icon = $icon;
        $this->watermark = $watermark;
        $this->about_image = $about_image;
    }
}
