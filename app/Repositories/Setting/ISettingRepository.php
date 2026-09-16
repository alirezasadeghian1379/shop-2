<?php
namespace App\Repositories\Setting;

use App\Repositories\Setting\Models\Setting;

interface ISettingRepository
{
    public function all() :array;
    public function findById(int $id) :?Setting;
    public function findByKey(string $key) :?Setting;
    public function updateOrCreate(array $data): bool;
    public function update(int $id,array $data): bool;
}
