<?php

namespace App\Repositories\Gallery\Contracts;

use App\Repositories\Gallery\Models\GalleryDb;

interface IGalleryDbRepository
{
    public function create(array $data):GalleryDb;
    public function updateByTypeId(int $id,array $data):GalleryDb;
    public function destroyByTypeId(int $id,string $type):bool;
    public function destroy(int $id):bool;
}
