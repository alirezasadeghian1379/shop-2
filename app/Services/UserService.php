<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected IUserRepository $userRepository,
    ){}

    public function all():Collection
    {
        return $this->userRepository->all();
    }
    public function paginate(int $perPage): PaginatorAdapter
    {
        return $this->userRepository->paginate($perPage);
    }
    public function findById(int $id): User
    {
        return $this->userRepository->findById($id);
    }
    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }
    public function update(int $id,array $data): User
    {
        return $this->userRepository->update($id,$data);
    }
    public function destroy(int $id): bool
    {
        return $this->userRepository->destroy($id);
    }
    public function updateProfile(int $id,array $data): bool
    {
        return $this->userRepository->updateProfile($id,$data);
    }
    public function getAllCount(): int
    {
        return $this->userRepository->all()->count();
    }
    public function getAllLatestByCount(int $count): Collection
    {
        return $this->userRepository->getAllLatestByCount($count);
    }
    public function getActiveComplete():Collection
    {
        return $this->userRepository->getActiveComplete();
    }
    public function getAllById(array $ids):Collection
    {
        return $this->userRepository->getAllById($ids);
    }
}
