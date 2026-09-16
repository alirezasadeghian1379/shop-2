<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\City\CityStoreRequest;
use App\Http\Requests\Web\City\CityUpdateRequest;
use App\Services\State\CityService;
use App\Services\State\ProvinceService;

class CityController extends Controller
{

    public function __construct(
        protected CityService $cityService,
        protected ProvinceService $provinceService
    ){
        $this->middleware('checkPermission:city');
    }

    public function index()
    {
        try {
            $cities = $this->cityService->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.cities.index',compact('cities'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.index');
        }
    }

    public function create()
    {
        try {
            $provinces = $this->provinceService->getAllActive();
            return view('admin.cities.create',compact('provinces'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.create');
        }
    }

    public function store(CityStoreRequest $request)
    {
        try {
            $this->cityService->create($request->all());
            alert()->success('تایید','شهر جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.cities.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.create');
        }
    }

    public function edit($id)
    {
        try {
            $city = $this->cityService->findById($id);
            $provinces = $this->provinceService->getAllActive();
            return view('admin.cities.create',compact('city','provinces'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.edit',['city' => $id]);
        }
    }

    public function update(CityUpdateRequest $request, $id)
    {
        try {
            $this->cityService->update($id,$request->all());
            alert()->success('تایید','شهر مورد نظر  با موفقیت ویرایش شد');
            return redirect()->route('admin.cities.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.edit',['city' => $id]);
        }
    }


    public function destroy($id)
    {
        try {
            $this->cityService->destroy($id);
            alert()->success('تایید','شهر مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.cities.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.cities.index');
        }
    }
}

