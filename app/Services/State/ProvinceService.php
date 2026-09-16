<?php

namespace App\Services\State;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Contracts\IProvinceRepository;
use App\Repositories\State\Models\Province;
use Illuminate\Support\Collection;

class ProvinceService
{
    public function __construct(
        protected IProvinceRepository $provinceRepository,
    ){}

    public function getAll(): Collection
    {
        return $this->provinceRepository->getAll();
    }
    public function getAllActive(): Collection
    {
        return $this->provinceRepository->getAllActive();
    }
    public function paginate(int $perPage): PaginatorAdapter
    {
        return $this->provinceRepository->paginate($perPage);
    }
    public function findById(int $id): Province
    {
        return $this->provinceRepository->findById($id);
    }
    public function findBySlug(string $slug): Province
    {
        return $this->provinceRepository->findBySlug($slug);
    }
    public function create(array $data): Province
    {
        return $this->provinceRepository->create($data);
    }
    public function update(int $id,array $data): Province
    {
        return $this->provinceRepository->update($id,$data);
    }
    public function destroy(int $id): bool
    {
        return $this->provinceRepository->destroy($id);
    }
}
