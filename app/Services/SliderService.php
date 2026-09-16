<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Slider\ISliderRepository;
use App\Repositories\Slider\Models\Slider;
use Illuminate\Support\Collection;

class SliderService
{
    public function __construct(
        protected ISliderRepository $slider
    ) {}

    public function all():Collection
    {
        return $this->slider->all();
    }
    public function getActiveNotExpiredAll():Collection
    {
        return $this->slider->getActiveNotExpiredAll();
    }

    public function getActiveNotExpiredAllByType(string $type):Collection
    {
        return $this->slider->getActiveNotExpiredAllByType($type);
    }

    public function paginate(int $perPage):PaginatorAdapter
    {
        return $this->slider->paginate($perPage);
    }

    public function findById(int $id):Slider
    {
        return $this->slider->findById($id);
    }

    public function create(array $data):Slider
    {
        return $this->slider->create($data);
    }
    public function update(int $id, array $data):Slider
    {
        return $this->slider->update($id, $data);
    }
    public function destroy(int $id):bool
    {
        return $this->slider->destroy($id);
    }
}
