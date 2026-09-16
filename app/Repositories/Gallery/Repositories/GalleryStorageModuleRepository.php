<?php

namespace App\Repositories\Gallery\Repositories;

use App\Repositories\Gallery\Contracts\IGalleryStorageRepository;
use App\Repositories\Gallery\Models\GalleryStorage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class GalleryStorageModuleRepository implements IGalleryStorageRepository
{

    public function upload($image, string $path): GalleryStorage
    {
        return $this->upload($image, $path);
    }

    public function update($image, string $path, int $oldId): GalleryStorage
    {
        return $this->update($image, $path, $oldId);
    }
    public function createWaterMark(string $imagePath): bool
    {
        return $this->createWaterMark($imagePath);
    }
    public function compressImage(File|UploadedFile $file): array
    {
        return $this->compressImage($file);
    }
}
