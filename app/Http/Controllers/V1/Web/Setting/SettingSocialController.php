<?php

namespace App\Http\Controllers\V1\Web\Setting;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingSocialController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:setting');
    }


    public function socialIndex()
    {
        try {
            $setting = $this->settingService->all();
            return view('admin.setting.social.index',compact('setting'));
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.social.index');
        }
    }
    public function socialUpdate(Request $request)
    {
        try {
            $this->settingService->updateOrCreate($request->get('settings'));
            alert()->success('تایید','تنظیمات با موفقیت ویرایش شد');
            return redirect()->route('admin.settings.social.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.social.index');
        }
    }
}
