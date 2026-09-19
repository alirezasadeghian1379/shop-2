<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('checkPermission:dashboard');
    }

    public function index()
    {
        try {
            return view('admin.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.index');
        }
    }
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            alert()->success('تایید','کش با موفقیت خالی شد');
            return redirect()->route('admin.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.index');
        }
    }
}
