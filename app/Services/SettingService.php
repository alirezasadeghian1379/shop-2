<?php

namespace App\Services;

use App\Helpers\Adapters\Exception\ExceptionAdapter;
use App\Repositories\Setting\ISettingRepository;
use App\Repositories\Setting\Models\Setting;

class SettingService
{
    public function __construct(
        protected ISettingRepository $setting
    ){}

    public function all():array
    {
        return $this->setting->all();
    }
    public function findById(int $id):?Setting
    {
        return $this->setting->findById($id);
    }
    public function findByKey(string $key):?Setting
    {
        return $this->setting->findByKey($key);
    }
    public function updateOrCreate(array $data): bool
    {
        return $this->setting->updateOrCreate($data);
    }

    public function update(int $id,array $data):bool
    {
        return $this->setting->update($id, $data);
    }
}
