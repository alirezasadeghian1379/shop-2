<?php

namespace App\Services\Gallery;

use App\Repositories\Gallery\Contracts\IGalleryDbRepository;
use App\Repositories\Gallery\Models\GalleryDb;

class GalleryDbService
{
    public function __construct(
        protected IGalleryDbRepository $galleryDbRepository
    ){}
    public function create(array $data):GalleryDb
    {
        return $this->galleryDbRepository->create($data);
    }

    public function updateByTypeId(int $id,array $data):GalleryDb
    {
        return $this->galleryDbRepository->updateByTypeId($id,$data);
    }

    public function destroy(int $id):bool
    {
        return $this->galleryDbRepository->destroy($id);
    }

    public function destroyByTypeId(int $id,string $type):bool
    {
        return $this->galleryDbRepository->destroyByTypeId($id,$type);
    }
}
