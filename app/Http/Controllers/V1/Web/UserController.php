<?php

namespace App\Http\Controllers\V1\Web;

use App\Enums\Gallery\StorageTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\UserStoreRequest;
use App\Http\Requests\Web\User\UserUpdateRequest;
use App\Services\Gallery\GalleryStorageService;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $user,
        protected GalleryStorageService $galleryStorageService
    ){
        $this->middleware('checkPermission:user');
    }
    public function index()
    {
        try {
            $users = $this->user->paginate($this->perPage());
            confirmDelete('تایید','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.users.index',compact('users'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.index');
        }
    }
    public function create()
    {
        try {
            return view('admin.users.create');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.create');
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $user = $this->user->create($request->all());
            if ($request->hasFile('avatar')) {
                $this->galleryStorageService->upload($request->file('avatar'), 'users',$user->id,StorageTypeEnum::AVATAR);
            }
            alert()->success('تایید','کاربر جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.users.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.create');
        }
    }
    public function edit($id)
    {
        try {
            $user = $this->user->findById($id);
            return view('admin.users.create',compact('user'));
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.create');
        }
    }
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $user = $this->user->update($id,$request->all());
            if ($request->hasFile('avatar')) {
                $this->galleryStorageService->update($request->file('avatar'),'users',$user->id,StorageTypeEnum::AVATAR,$user->avatar->id ?? null);
            }
            alert()->success('تایید','کاربر مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.users.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.create');
        }
    }

    public function destroy($id)
    {
        try {
            $this->user->destroy($id);
            alert()->success('تایید','کاربر مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.users.index');
        } catch (Exception $exception) {
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.users.index');
        }
    }
}

