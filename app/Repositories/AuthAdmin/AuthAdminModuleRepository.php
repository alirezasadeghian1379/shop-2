<?php
namespace App\Repositories\AuthAdmin;

use App\Helpers\Adapters\Exception\Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthAdminModuleRepository implements IAuthAdminRepository
{
    public function loginByEmailPassword(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();
        if (!$user) throw new Exception('اطلاعاتی یافت نشد!',422);
        if (!$user->active) throw new Exception('حساب کاربری شما غیر فعال است ،با پشتیبانی تماس بگیرید',422);
        $attempt = ['email' => $email, 'password'=> $password];
        if(!Auth::attempt($attempt)) throw new Exception('اطلاعات وارد شده صحیح نیست',422);
        return Auth::attempt($attempt);
    }

    public function logout(): bool
    {
        Auth::logout();
        return true;
    }
}
