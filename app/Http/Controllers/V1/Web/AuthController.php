<?php

namespace App\Http\Controllers\V1\Web;

use App\Helpers\Adapters\Exception\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\AuthLoginRequest;
use App\Services\AuthAdminService;

class AuthController extends Controller
{

    public function __construct(
        protected AuthAdminService $authAdminService
    ){}

    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $this->authAdminService->loginByEmailPassword($request->get('email'),$request->get('password'));
            return redirect()->route('admin.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.login.index');
        }
    }

    public function logout()
    {
        try {
            $this->authAdminService->logout();
            return redirect()->route('admin.login.index');
        } catch (Exception $exception){
            alert()->error('خطا',$exception->getMessage());
            return redirect()->route('admin.index');
        }
    }
}
