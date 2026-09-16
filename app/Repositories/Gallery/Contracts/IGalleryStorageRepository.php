<?php

namespace App\Repositories\Gallery\Contracts;

use App\Repositories\Gallery\Models\GalleryStorage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface IGalleryStorageRepository
{
    public function upload($image,string $path):GalleryStorage;
    public function update($image,string $path,int $oldId):GalleryStorage;
    public function createWaterMark(string $imagePath):bool;
    public function compressImage(File|UploadedFile $file):array;
}
