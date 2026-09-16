<?php
namespace App\Repositories\AuthAdmin;

interface IAuthAdminRepository
{
    public function loginByEmailPassword(string $email, string $password): bool;
    public function logout(): bool;
}
