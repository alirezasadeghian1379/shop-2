<?php

namespace App\Repositories\Gallery\Repositories;

use App\Helpers\Adapters\Exception\Exception;
use App\Repositories\Gallery\Contracts\IGalleryDbRepository;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Models\Storage as StorageModel;
use Illuminate\Support\Facades\File;

class GalleryDbModuleRepository implements IGalleryDbRepository
{

    public function create(array $data): GalleryDb
    {
        $storage = StorageModel::create([
            'type' => $data['type'],
            'path' => $data['path'],
            'item_id' => $data['item_id'],
            'registered' => $data['registered'],
        ]);
        return new GalleryDb(
            $storage->id,
            $storage->uuid,
            $storage->type,
            $storage->path,
            $storage->item_id,
            $storage->registered,
            $storage->created_at,
            $storage->updated_at,
        );
    }

    public function updateByTypeId(int $id, array $data): GalleryDb
    {
        $storage = StorageModel::where('id',$id)->first();
        if (!$storage) throw new Exception('اطلاعاتی یافت نشد!',404);
        $storage->update($data);
        return new GalleryDb(
            $storage->id,
            $storage->uuid,
            $storage->type,
            $storage->path,
            $storage->item_id,
            $storage->registered,
            $storage->created_at,
            $storage->updated_at,
        );
    }

    public function destroyByTypeId(int $id, string $type): bool
    {
        $storage = StorageModel::where('type',$type)->where('id', $id)->first();
        if (!$storage) throw new Exception('اطلاعاتی یافت نشد!',404);
        if (File::exists(storage_path('app/public/'.$storage->path))){
            File::delete(storage_path('app/public/'.$storage->path));
        }
        $storage->delete();
        return true;
    }

    public function destroy(int $id): bool
    {
        $storage = StorageModel::where('id', $id)->first();
        if (!$storage) throw new Exception('اطلاعاتی یافت نشد!',404);
        if (File::exists(storage_path('app/public/'.$storage->path))){
            File::delete(storage_path('app/public/'.$storage->path));
        }
        $storage->delete();
        return true;
    }
}
