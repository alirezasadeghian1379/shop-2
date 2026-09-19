<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Notification\NotificationStoreRequest;
use App\Http\Requests\Web\Notification\NotificationUpdateRequest;
use App\Services\FirebaseNotificationService;
use App\Services\NotificationService;
use App\Services\UserNotificationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notification,
        protected UserService $user,
        protected UserNotificationService $userNotification,
        protected FirebaseNotificationService $firebaseNotificationService,
    ){
        $this->middleware('checkPermission:notification');
    }


    public function index()
    {
        try {
            $notifications = $this->notification->paginate($this->perPage());
            confirmDelete('حذف','آیا از حذف این آیتم اطمینان دارید؟');
            return view('admin.notifications.index',compact('notifications'));
        } catch (Exception $exception){
            alert()->error('error',$exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }

    public function create()
    {
        try {
            $users = $this->user->getActiveComplete();
            return view('admin.notifications.create',compact('users'));
        } catch (Exception $exception){
            alert()->error('error',$exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }

    public function store(NotificationStoreRequest $request)
    {
        try {
            $notification = $this->notification->create($request->all());
            $userIds = collect($notification->users)->pluck('id')->toArray();
            $this->firebaseNotificationService->send($userIds,$notification->title,$notification->message,$notification->url,false);
            alert()->success('تایید','اعلان جدید با موفقیت ایجاد شد');
            return redirect()->route('admin.notifications.index');
        } catch (Exception $exception){
            alert()->error('error',$exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }


    public function edit($id)
    {
        try {
            $notification = $this->notification->findById($id);
            $users = $this->user->getActiveComplete();
            $userNotifications = $this->userNotification->getAllByNotificationId($notification->id);
            return view('admin.notifications.create',compact('notification','users','userNotifications'));
        } catch (Exception $exception){
            alert()->error('error',$exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }

    public function update(NotificationUpdateRequest $request, $id)
    {
        try {
            $this->notification->update($id,$request->all());
            alert()->success('تایید','اعلان مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.notifications.index');
        } catch (Exception $exception){
            alert()->error('error',$exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }

    public function destroy($id)
    {
        try {
            $this->notification->destroy($id);
            alert()->success('تایید', 'اعلان مورد نظر با موفقیت حذف شد');
            return redirect()->route('admin.notifications.index');
        } catch (Exception $exception) {
            alert()->error('error', $exception->getMessage());
            return redirect()->route('admin.notifications.index');
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $this->notification->destroyAll($request->get('ids'));
            alert()->success('تایید','اعلان های مورد نظر با موفقیت حذف شدند');
            return Response::success([],'اعلان های مورد نظر با موفقیت حذف شدند',200);
        } catch (Exception $exception){
            return Response::error('error',$exception->getMessage(),$exception->getCode());
        }
    }
}

