<?php

namespace App\Http\Controllers\V1\Web;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\Gallery\GalleryStorageService;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\Web\Admin\AdminStoreRequest;
use App\Http\Requests\Web\Admin\AdminUpdateRequest;

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(
        protected AdminService $admin,
        protected RoleService $role,
        protected GalleryStorageService $galleryStorageService,
    ) {
        $this->middleware('checkPermission:admin');
    }

    public function index()
    {
        try {
            $admins = $this->admin->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.admins.index', compact('admins'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.index');
        }
    }

    public function create()
    {
        try {
            $roles = $this->role->all();
            return view('admin.admins.create',compact('roles'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.create');
        }
    }

    public function store(AdminStoreRequest $request)
    {
        try {
            $admin = $this->admin->create($request->all());
            if ($request->hasFile('avatar')) {
                $this->galleryStorageService->upload($request->file('avatar'),'users',$admin->id,StorageTypeEnum::AVATAR);
            }
            alert()->success('تایید','مدیر جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.admins.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.create');
        }
    }

    public function edit($id)
    {
        try {
            $admin = $this->admin->findById($id);
            $this->authorize('view', $admin);
            $roles = $this->role->all();
            return view('admin.admins.create',compact('admin','roles'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.edit',['admin' => $id]);
        }
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        try {
            $admin = $this->admin->findById($id);
            $this->authorize('update', $admin);
            $admin = $this->admin->update($admin->id,$request->all());
            if ($request->hasFile('avatar')) {
                $this->galleryStorageService->update($request->file('avatar'),'users',$admin->id,StorageTypeEnum::AVATAR,$admin->avatar->id ?? null);
            }
            alert()->success('تایید','مدیر مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.admins.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.edit',['admin' => $id]);
        }
    }

    public function destroy($id)
    {
        try {
            $admin = $this->admin->findById($id);
            $this->authorize('destroy', $admin);
            $this->admin->destroy($admin->id);
            alert()->success('تایید','مدیر مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.admins.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.admins.index');
        }
    }
}

