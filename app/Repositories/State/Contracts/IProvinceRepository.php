<?php

namespace App\Repositories\State\Contracts;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Models\Province;
use Illuminate\Support\Collection;

interface IProvinceRepository
{
    public function getAll(): Collection;
    public function getAllActive(): Collection;
    public function paginate(int $perPage): PaginatorAdapter;
    public function findById(int $id): Province;
    public function findBySlug(string $slug): Province;
    public function create(array $data): Province;
    public function update(int $id,array $data): Province;
    public function destroy(int $id): bool;
}
