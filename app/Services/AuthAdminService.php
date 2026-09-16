<?php

namespace App\Services;

use App\Repositories\AuthAdmin\IAuthAdminRepository;

class AuthAdminService
{
    public function __construct(
        protected IAuthAdminRepository $authAdminRepository
    ){}
    public function loginByEmailPassword(string $email, string $password): bool
    {
        return $this->authAdminRepository->loginByEmailPassword($email, $password);
    }
    public function logout(): bool
    {
        return $this->authAdminRepository->logout();
    }
}
