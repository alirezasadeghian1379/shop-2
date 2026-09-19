<?php

namespace App\Http\Controllers\V1\Web\Setting;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingWatermarkController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:setting');
    }


    public function watermarkIndex()
    {
        try {
            $setting = $this->settingService->all();
            return view('admin.setting.watermark.index',compact('setting'));
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.watermark.index');
        }
    }
    public function watermarkUpdate(Request $request)
    {
        try {
            $this->settingService->updateOrCreate($request->get('settings'));
            if ($request->hasFile('watermark')) {
                $watermark = $this->settingService->findByKey('watermark');
                $this->galleryStorageService->update($request->file('watermark'),'settings',$watermark->id,StorageTypeEnum::WATERMARK,$watermark->watermark->id ?? null);
            }
            alert()->success('تایید','تنظیمات با موفقیت ویرایش شد');
            return redirect()->route('admin.settings.watermark.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.watermark.index');
        }
    }
}
