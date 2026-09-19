<?php
namespace App\Repositories\Setting;

use App\Helpers\Adapters\Exception\Exception;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Repositories\Setting\Models\Setting;
use App\Models\Setting as SettingModel;

class SettingModuleRepository implements ISettingRepository
{
    public function all(): array
    {
        $settings = SettingModel::latest()->get()
            ->map(function($item) {
                $value = $item->value;
                if ($item->key === 'logo') {
                    $logo = $item->logo()->first();
                    $value = $logo ? $logo->path : null;
                } elseif ($item->key === 'icon') {
                    $icon = $item->icon()->first();
                    $value = $icon ? $icon->path : null;
                }  elseif ($item->key === 'watermark') {
                    $watermark = $item->watermark()->first();
                    $value = $watermark ? $watermark->path : null;
                }  elseif ($item->key === 'about_image') {
                    $about_image = $item->about_image()->first();
                    $value = $about_image ? $about_image->path : null;
                } else {
                    $value = $item->value;
                }
                return new Setting(
                    $item->id,
                    $item->key,
                    $value
                );
        });
        return $settings->mapWithKeys(fn($item) => [$item->key => $item->value])->toArray();
    }

    public function findById(int $id): ?Setting
    {
        $setting = SettingModel::where('id', $id)->first();
        if (!$setting) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Setting(
            $setting->id,
            $setting->key,
            $setting->value,
        );
    }

    public function findByKey(string $key): ?Setting
    {
        $setting = SettingModel::where('key', $key)->first();
        if (!$setting) return null;
        return new Setting(
            $setting->id,
            $setting->key,
            $setting->value,
            $setting->logo()->get()->map(fn($logo) => new GalleryDb(
                $logo->id,
                $logo->uuid,
                $logo->type,
                $logo->path,
                $logo->item_id,
                $logo->registered,
                $logo->created_at,
                $logo->updated_at,
            ))->first(),
            $setting->icon()->get()->map(fn($icon) => new GalleryDb(
                $icon->id,
                $icon->uuid,
                $icon->type,
                $icon->path,
                $icon->item_id,
                $icon->registered,
                $icon->created_at,
                $icon->updated_at,
            ))->first(),
            $setting->watermark()->get()->map(fn($icon) => new GalleryDb(
                $icon->id,
                $icon->uuid,
                $icon->type,
                $icon->path,
                $icon->item_id,
                $icon->registered,
                $icon->created_at,
                $icon->updated_at,
            ))->first(),
            $setting->about_image()->get()->map(fn($icon) => new GalleryDb(
                $icon->id,
                $icon->uuid,
                $icon->type,
                $icon->path,
                $icon->item_id,
                $icon->registered,
                $icon->created_at,
                $icon->updated_at,
            ))->first(),
        );
    }
    public function updateOrCreate(array $data): bool
    {
        $options = ['watermark_ids','social'];
//        foreach ($options as $option) {
//            if (!array_key_exists($option, $data)) {
//                $data[$option] = null;
//            }
//        }
        foreach ($data as $key => $value) {
            $finalValue = (in_array($key, $options) && $value !== null) ? json_encode($value) : $value;
            SettingModel::updateOrCreate([
                'key' => $key,
            ],[
                'key' => $key,
                'value' => $finalValue,
            ]);
        }
        return true;
    }

    public function update(int $id,array $data):bool
    {
        $setting = SettingModel::where('id',$id)->first();
        if (!$setting) throw new Exception('اطلاعاتی یافت نشد!',404);
        $setting->update($data);
        return true;
    }
}
