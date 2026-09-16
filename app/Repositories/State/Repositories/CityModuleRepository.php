<?php

namespace App\Repositories\State\Repositories;

use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\State\Contracts\ICityRepository;
use App\Repositories\State\Models\City;
use App\Repositories\State\Models\Province;
use Illuminate\Support\Collection;
use App\Models\City as CityModel;
use App\Models\Province as ProvinceModel;
class CityModuleRepository implements ICityRepository
{

    public function getAll(): Collection
    {
        $cities = CityModel::latest()->get()->map(fn($city) => new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        ));
        return $cities;
    }

    public function getAllActive(): Collection
    {
        $cities = CityModel::where('is_active',1)->latest()->get()->map(fn($city) => new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        ));
        return $cities;
    }

    public function paginate(int $perPage): PaginatorAdapter
    {
        $cities = CityModel::latest()->paginate($perPage);
        $cities->setCollection(
            $cities->getCollection()->map(fn($city) => new City(
                $city->id,
                $city->name,
                $city->slug,
                $city->latitude,
                $city->longitude,
                $city->is_active,
                $city->created_at,
                $city->province()->get()->map(fn($province) => new Province(
                    $province->id,
                    $province->name,
                    $province->slug,
                    $province->latitude,
                    $province->longitude,
                    $province->is_active,
                    $province->created_at,
                ))->first()
            ))
        );
        return new EloquentPaginatorAdapter($cities);
    }

    public function findById(int $id): City
    {
        $city = CityModel::where('id', $id)->first();
        if (!$city) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        );
    }

    public function findBySlug(string $slug): City
    {
        $city = CityModel::where('slug', $slug)->first();
        if (!$city) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        );
    }

    public function create(array $data): City
    {
        $city = CityModel::create([
            'name' => $data['name'],
            'latitude' => isset($data['latitude']) ? $data['latitude']:null,
            'longitude' => isset($data['longitude']) ? $data['longitude']:null,
            'is_active' => isset($data['is_active']) && $data['is_active'] == 'on' ? 1:0,
            'province_id' => $data['province_id'],
        ]);
        return new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        );
    }

    public function update(int $id, array $data): City
    {
        $city = CityModel::where('id', $id)->first();
        if (!$city) throw new Exception('اطلاعاتی یافت نشد!',404);
        $city->update([
            'name' => $data['name'],
            'latitude' => isset($data['latitude']) ? $data['latitude']:null,
            'longitude' => isset($data['longitude']) ? $data['longitude']:null,
            'is_active' => isset($data['is_active']) && $data['is_active'] == 'on' ? 1:0,
            'province_id' => $data['province_id'],
        ]);
        return new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        );
    }

    public function destroy(int $id): bool
    {
        $city = CityModel::where('id', $id)->first();
        if (!$city) throw new Exception('اطلاعاتی یافت نشد!',404);
        return $city->delete();
    }

    public function getAllActiveByProvinceId(int $provinceId):Collection
    {
        $province = ProvinceModel::where('id',$provinceId)->first();
        if (!$province) throw new Exception('اطلاعاتی یافت نشد!',404);
        $cities = CityModel::where('province_id',$province->id)->where('is_active',1)->latest()->get()->map(fn($city) => new City(
            $city->id,
            $city->name,
            $city->slug,
            $city->latitude,
            $city->longitude,
            $city->is_active,
            $city->created_at,
            $city->province()->get()->map(fn($province) => new Province(
                $province->id,
                $province->name,
                $province->slug,
                $province->latitude,
                $province->longitude,
                $province->is_active,
                $province->created_at,
            ))->first()
        ));
        return $cities;
    }
}
