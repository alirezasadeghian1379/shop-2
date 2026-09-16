<?php

namespace App\Repositories\Slider;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Slider\Models\Slider;
use Illuminate\Support\Collection;

interface ISliderRepository {
    public function all(): Collection;
    public function getActiveNotExpiredAll(): Collection;
    public function getActiveNotExpiredAllByType(string $type): Collection;
    public function paginate(int $perPage) :PaginatorAdapter;
    public function findById(int $id):Slider;
    public function create(array $data):Slider;
    public function update(int $id,array $data):Slider;
    public function destroy(int $id):bool;
}
