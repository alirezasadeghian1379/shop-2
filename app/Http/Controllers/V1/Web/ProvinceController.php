<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Province\ProvincStoreRequest;
use App\Http\Requests\Web\Province\ProvincUpdateRequest;
use App\Services\State\ProvinceService;

class ProvinceController extends Controller
{
    public function __construct(
        protected ProvinceService $provinceService
    ){
        $this->middleware('checkPermission:province');
    }

    public function index()
    {
        try {
            $provinces = $this->provinceService->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.provinces.index',compact('provinces'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.index');
        }
    }

    public function create()
    {
        try {
            return view('admin.provinces.create');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.create');
        }
    }

    public function store(ProvincStoreRequest $request)
    {
        try {
            $this->provinceService->create($request->all());
            alert()->success('تایید','استان جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.provinces.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.create');
        }
    }

    public function edit($id)
    {
        try {
            $province = $this->provinceService->findById($id);
            return view('admin.provinces.create',compact('province'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.edit',['province' => $id]);
        }
    }

    public function update(ProvincUpdateRequest $request, $id)
    {
        try {
            $this->provinceService->update($id,$request->all());
            alert()->success('تایید','استان مورد نظر  با موفقیت ویرایش شد');
            return redirect()->route('admin.provinces.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.edit',['province' => $id]);
        }
    }


    public function destroy($id)
    {
        try {
            $this->provinceService->destroy($id);
            alert()->success('تایید','استان مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.provinces.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.provinces.index');
        }
    }
}

