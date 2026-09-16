<?php

namespace App\Http\Controllers\V1\Web;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:setting');
    }

    public function index()
    {
        try {
            $setting = $this->settingService->all();
            return view('admin.setting.index',compact('setting'));
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.index');
        }
    }
    public function update(Request $request)
    {
        try {
            $this->settingService->updateOrCreate($request->get('settings'));
            if ($request->hasFile('logo')) {
                $logo = $this->settingService->findByKey('logo');
                $this->galleryStorageService->update($request->file('logo'),'settings',$logo->id,StorageTypeEnum::LOGO,$logo->logo->id ?? null);
            }
            if ($request->hasFile('icon')) {
                $icon = $this->settingService->findByKey('icon');
                $this->galleryStorageService->update($request->file('icon'),'settings',$icon->id,StorageTypeEnum::ICON,$icon->icon->id ?? null);
            }
            if ($request->hasFile('watermark')) {
                $watermark = $this->settingService->findByKey('watermark');
                $this->galleryStorageService->update($request->file('watermark'),'settings',$watermark->id,StorageTypeEnum::WATERMARK,$watermark->watermark->id ?? null);
            }
            alert()->success('تایید','تنظیمات با موفقیت ویرایش شد');
            return redirect()->route('admin.settings.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.index');
        }
    }

}
