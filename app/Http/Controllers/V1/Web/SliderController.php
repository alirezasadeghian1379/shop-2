<?php

namespace App\Http\Controllers\V1\Web;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Slider\SliderStoreRequet;
use App\Http\Requests\Web\Slider\SliderUpdateRequet;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SliderService;

class SliderController extends Controller
{
    public function __construct(
        protected SliderService $slider,
        protected GalleryStorageService $galleryStorageService,
    ) {
        $this->middleware('checkPermission:slider');
    }

    public function index()
    {
        try {
            $sliders = $this->slider->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.sliders.index',compact('sliders'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.create');
        }
    }


    public function create()
    {
        try {
            return view('admin.sliders.edit');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.index');
        }
    }


    public function store(SliderStoreRequet $request)
    {
        try {
            $slider = $this->slider->create($request->all());
            if ($request->hasFile('image')) {
                $this->galleryStorageService->upload($request->file('image'),'sliders',$slider->id,StorageTypeEnum::SLIDER);
            }
            alert()->success('تایید','اسلایدر جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.sliders.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.index');
        }
    }

    public function edit($id)
    {
        try {
            $slider = $this->slider->findById($id);
            return view('admin.sliders.edit',compact('slider'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.index');
        }
    }


    public function update(SliderUpdateRequet $request, $id)
    {
        try {
            $slider = $this->slider->update($id,$request->all());
            if ($request->hasFile('image')) {
                $this->galleryStorageService->update($request->file('image'),'sliders',$slider->id,StorageTypeEnum::SLIDER,$slider->image->id ?? null);
            }
            alert()->success('تایید','اسلایدر مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.sliders.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.index');
        }
    }


    public function destroy($id)
    {
        try {
            $this->slider->destroy($id);
            alert()->success('تایید','اسلایدر مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.sliders.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.sliders.index');
        }
    }
}

