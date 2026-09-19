<?php

namespace App\Http\Controllers\V1\Web\Setting;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingAboutController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:setting');
    }

    public function aboutIndex()
    {
        try {
            $setting = $this->settingService->all();
            return view('admin.setting.about.index',compact('setting'));
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.about.index');
        }
    }
    public function aboutUpdate(Request $request)
    {
        try {
            $this->settingService->updateOrCreate($request->get('settings'));
            if ($request->hasFile('about_image')) {
                $aboutImage = $this->settingService->findByKey('about_image');
                $this->galleryStorageService->update($request->file('about_image'),'settings',$aboutImage->id,StorageTypeEnum::ABOUT,$aboutImage->aboutImage->id ?? null);
            }
            alert()->success('تایید','تنظیمات با موفقیت ویرایش شد');
            return redirect()->route('admin.settings.about.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.about.index');
        }
    }
}
