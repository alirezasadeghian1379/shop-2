<?php

namespace App\Services\State;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Contracts\ICityRepository;
use App\Repositories\State\Models\City;
use Illuminate\Support\Collection;

class CityService
{
    public function __construct(
        protected ICityRepository $cityRepository,
    ){}
    public function getAll():Collection
    {
        return $this->cityRepository->getAllActive();
    }
    public function getAllActive():Collection
    {
        return $this->cityRepository->getAllActive();
    }
    public function paginate(int $perPage):PaginatorAdapter
    {
        return $this->cityRepository->paginate($perPage);
    }
    public function findById(int $id):City
    {
        return $this->cityRepository->findById($id);
    }
    public function findBySlug(string $slug):City
    {
        return $this->cityRepository->findBySlug($slug);
    }
    public function create(array $data):City
    {
        return $this->cityRepository->create($data);
    }
    public function update(int $id,array $data):City
    {
        return $this->cityRepository->update($id,$data);
    }
    public function destroy(int $id):bool
    {
        return $this->cityRepository->destroy($id);
    }
    public function getAllActiveByProvinceId(int $provinceId):Collection
    {
        return $this->cityRepository->getAllActiveByProvinceId($provinceId);
    }
}
