<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\Web\Role\RoleStoreRequest;
use App\Http\Requests\Web\Role\RoleUpdateRequest;

class RoleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(
        protected RoleService $role,
    ){
        $this->middleware('checkPermission:role');
    }

    public function index()
    {
        try {
            $roles = $this->role->paginate($this->perPage());
            confirmDelete('حذف', 'آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.roles.index', compact('roles'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.index');
        }
    }

    public function create()
    {
        try {
            return view('admin.roles.create');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.create');
        }
    }
    public function store(RoleStoreRequest $request)
    {
        try {
            $this->role->create($request->all());
            alert()->success('تایید', 'نقش جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.roles.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.create');
        }
    }

    public function edit($id)
    {
        try {
            $role = $this->role->findById($id);
            $this->authorize('view', $role);
            return view('admin.roles.create', compact('role'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.edit',['role' => $id]);
        }
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            $role = $this->role->findById($id);
            $this->authorize('update', $role);
            $this->role->update($role->id, $request->all());
            alert()->success('تایید', 'نقش مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.roles.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.edit',['role' => $id]);
        }
    }

    public function destroy($id)
    {
        try {
            $role = $this->role->findById($id);
            $this->authorize('destroy', $role);
            $this->role->destroy($role->id);
            alert()->success('تایید', 'نقش مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.roles.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.roles.index');
        }
    }
}
