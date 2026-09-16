<?php

namespace App\Repositories\User;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\User\Models\User;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function all():Collection;
    public function paginate(int $perPage): PaginatorAdapter;
    public function findById(int $id): User;
    public function create(array $data): User;
    public function update(int $id,array $data): User;
    public function destroy(int $id): bool;
    public function updateProfile(int $id,array $data): bool;
    public function getAllCount(): int;
    public function getAllLatestByCount(int $count): Collection;
}
