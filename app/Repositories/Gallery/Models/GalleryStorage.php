<?php

namespace App\Repositories\Gallery\Models;

class GalleryStorage
{
    public string $path;

    public function __construct(
        string $path,
    )
    {
        $this->path = $path;
    }
}
