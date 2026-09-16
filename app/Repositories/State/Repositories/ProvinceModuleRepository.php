<?php

namespace App\Repositories\State\Repositories;

use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Models\City;
use App\Repositories\State\Contracts\IProvinceRepository;
use App\Repositories\State\Models\Province;
use Illuminate\Support\Collection;
use App\Models\Province as ProvinceModel;
class ProvinceModuleRepository implements IProvinceRepository
{

    public function getAll(): Collection
    {
        $provinces = ProvinceModel::latest()->get()->map(fn($province) => new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        ));
        return $provinces;
    }

    public function getAllActive(): Collection
    {
        $provinces = ProvinceModel::where('is_active',1)->latest()->get()->map(fn($province) => new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        ));
        return $provinces;
    }

    public function paginate(int $perPage): PaginatorAdapter
    {
        $provinces = ProvinceModel::latest()->paginate($perPage);
        $provinces->setCollection(
            $provinces->getCollection()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
                $province->cities()->get()->map(fn($city) => new City(
                    $city->id,
                    $city->name,
                    $city->slug,
                    $city->latitude,
                    $city->longitude,
                    $city->is_active,
                    $city->created_at,
                ))
            ))
        );
        return new EloquentPaginatorAdapter($provinces);
    }

    public function findById(int $id): Province
    {
        $province = ProvinceModel::where('id', $id)->first();
        if (!$province) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        );
    }

    public function findBySlug(string $slug): Province
    {
        $province = ProvinceModel::where('slug', $slug)->first();
        if (!$province) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        );
    }

    public function create(array $data): Province
    {
        $province = ProvinceModel::create([
            'name' => $data['name'],
            'latitude' => isset($data['latitude']) ? $data['latitude']:null,
            'longitude' => isset($data['longitude']) ? $data['longitude']:null,
            'is_active' => isset($data['is_active']) && $data['is_active'] == 'on' ? 1:0,
        ]);
        return new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        );
    }

    public function update(int $id, array $data): Province
    {
        $province = ProvinceModel::where('id', $id)->first();
        if (!$province) throw new Exception('اطلاعاتی یافت نشد!',404);
        $province->update([
            'name' => $data['name'],
            'latitude' => isset($data['latitude']) ? $data['latitude']:null,
            'longitude' => isset($data['longitude']) ? $data['longitude']:null,
            'is_active' => isset($data['is_active']) && $data['is_active'] == 'on' ? 1:0,
        ]);
        return new Province(
            $province->id,
            $province->name,
            $province->slug,
            $province->latitude,
            $province->longitude,
            $province->is_active,
            $province->created_at,
            $province->cities()->get()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
            ))
        );
    }

    public function destroy(int $id): bool
    {
        $province = ProvinceModel::where('id', $id)->first();
        if (!$province) throw new Exception('اطلاعاتی یافت نشد!',404);
        if ($province->cities()->count() > 0) throw new Exception('برای این استان شهر ثبت شده و قابلیت حذف ندارد.',422);
        $province->delete();
        return true;
    }
}
