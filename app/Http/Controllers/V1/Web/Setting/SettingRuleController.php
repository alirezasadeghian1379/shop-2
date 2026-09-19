<?php

namespace App\Http\Controllers\V1\Web\Setting;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\Gallery\GalleryStorageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingRuleController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:setting');
    }

    public function ruleIndex()
    {
        try {
            $setting = $this->settingService->all();
            return view('admin.setting.rule.index',compact('setting'));
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.rule.index');
        }
    }
    public function ruleUpdate(Request $request)
    {
        try {
            $this->settingService->updateOrCreate($request->get('settings'));
            alert()->success('تایید','تنظیمات با موفقیت ویرایش شد');
            return redirect()->route('admin.settings.rule.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.settings.rule.index');
        }
    }
}
