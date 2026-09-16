<?php

namespace App\Repositories\State\Contracts;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Models\City;
use Illuminate\Support\Collection;

interface ICityRepository
{
    public function getAll():Collection;
    public function getAllActive():Collection;
    public function paginate(int $perPage):PaginatorAdapter;
    public function findById(int $id):City;
    public function findBySlug(string $slug):City;
    public function create(array $data):City;
    public function update(int $id,array $data):City;
    public function destroy(int $id):bool;
    public function getAllActiveByProvinceId(int $provinceId):Collection;
}
