<?php

namespace App\Repositories\Slider;

use App\Helpers\Adapters\Exception\Exception;
use App\Helpers\Adapters\Paginator\EloquentPaginatorAdapter;
use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Gallery\Models\GalleryDb;
use App\Repositories\Slider\Models\Slider;
use Illuminate\Support\Facades\File;
use App\Models\Slider as SliderModel;
use Illuminate\Support\Collection;

class SliderModuleRepository implements ISliderRepository
{
    public function all(): Collection
    {
        $sliders = SliderModel::latest()
            ->get()
            ->map(fn($r) => new Slider(
                $r->id,
                $r->title,
                $r->description,
                $r->link,
                $r->active,
                $r->expired_at,
                $r->created_at,
                $r->image()->get()->map(fn ($image) => new GalleryDb(
                    $image->id,
                    $image->uuid,
                    $image->type,
                    $image->path,
                    $image->item_id,
                    $image->registered,
                    $image->created_at,
                    $image->updated_at,
                ))->first(),
            ));
        return $sliders;
    }

    public function getActiveNotExpiredAll():Collection
    {
        $sliders = SliderModel::where('active',1)->where('expired_at' , '>',now())->latest()
            ->get()
            ->map(fn($r) => new Slider(
                $r->id,
                $r->title,
                $r->description,
                $r->link,
                $r->active,
                $r->expired_at,
                $r->created_at,
                $r->image()->get()->map(fn ($image) => new GalleryDb(
                    $image->id,
                    $image->uuid,
                    $image->type,
                    $image->path,
                    $image->item_id,
                    $image->registered,
                    $image->created_at,
                    $image->updated_at,
                ))->first(),
            ));
        return $sliders;
    }
    public function getActiveNotExpiredAllByType(string $type):Collection
    {
        $sliders = SliderModel::where('type',$type)->where('active',1)->where('expired_at' , '>',now())->orderBy('created_at','ASC')
            ->get()
            ->map(fn($r) => new Slider(
                $r->id,
                $r->title,
                $r->description,
                $r->link,
                $r->active,
                $r->expired_at,
                $r->created_at,
                $r->image()->get()->map(fn ($image) => new GalleryDb(
                    $image->id,
                    $image->uuid,
                    $image->type,
                    $image->path,
                    $image->item_id,
                    $image->registered,
                    $image->created_at,
                    $image->updated_at,
                ))->first(),
            ));
        return $sliders;
    }
    public function paginate($perPage): PaginatorAdapter
    {
        $sliders = SliderModel::latest()
            ->paginate($perPage);
        $sliders->setCollection(
            $sliders->getCollection()->map(
                fn ($r) => new Slider(
                    $r->id,
                    $r->title,
                    $r->description,
                    $r->link,
                    $r->active,
                    $r->expired_at,
                    $r->created_at,
                    $r->image()->get()->map(fn ($image) => new GalleryDb(
                        $image->id,
                        $image->uuid,
                        $image->type,
                        $image->path,
                        $image->item_id,
                        $image->registered,
                        $image->created_at,
                        $image->updated_at,
                    ))->first(),
                )
            )
        );

        return new EloquentPaginatorAdapter($sliders);
    }

    public function findById($id):Slider
    {
        $slider = SliderModel::where('id',$id)->first();
        if (!$slider) throw new Exception('اطلاعاتی یافت نشد!',404);
        return new Slider(
            $slider->id,
            $slider->title,
            $slider->description,
            $slider->link,
            $slider->active,
            $slider->expired_at,
            $slider->created_at,
            $slider->image()->get()->map(fn ($image) => new GalleryDb(
                $image->id,
                $image->uuid,
                $image->type,
                $image->path,
                $image->item_id,
                $image->registered,
                $image->created_at,
                $image->updated_at,
            ))->first(),
        );
    }

    public function create($data):Slider
    {
        $slider = SliderModel::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'link' => $data['link'],
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
            'expired_at' => convertDateTime($data['expired_at']),
            'type' => $data['type'],
        ]);
        return new Slider(
            $slider->id,
            $slider->title,
            $slider->description,
            $slider->link,
            $slider->active,
            $slider->expired_at,
            $slider->created_at,
            $slider->image()->get()->map(fn ($image) => new GalleryDb(
                $image->id,
                $image->uuid,
                $image->type,
                $image->path,
                $image->item_id,
                $image->registered,
                $image->created_at,
                $image->updated_at,
            ))->first(),
        );
    }

    public function update($id, $data):Slider
    {
        $slider = SliderModel::where('id',$id)->first();
        if (!$slider) throw new Exception('اطلاعاتی یافت نشد!',404);
        $slider->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'link' => $data['link'],
            'active' => isset($data['active']) && $data['active'] == 'on' ? 1 : 0,
            'expired_at' => convertDateTime($data['expired_at']),
            'type' => $data['type'],
        ]);
        return new Slider(
            $slider->id,
            $slider->title,
            $slider->description,
            $slider->link,
            $slider->active,
            $slider->expired_at,
            $slider->created_at,
            $slider->image()->get()->map(fn ($image) => new GalleryDb(
                $image->id,
                $image->uuid,
                $image->type,
                $image->path,
                $image->item_id,
                $image->registered,
                $image->created_at,
                $image->updated_at,
            ))->first(),
        );
    }

    public function destroy($id):bool
    {
        $slider = SliderModel::where('id',$id)->first();
        if (!$slider) throw new Exception('اطلاعاتی یافت نشد!',404);
        if ($slider->image()->count()){
            if (File::exists('storage/'.$slider->image->path)){
                File::delete('storage/'.$slider->image->path);
            }
            $slider->image()->delete();
        }
        $slider->delete();
        return true;
    }
}
