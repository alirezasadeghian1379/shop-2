<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\Models\Role;
use Illuminate\Support\Collection;

class RoleService {
    public function __construct(
        protected IRoleRepository $role
    ) {}

    public function all():Collection
    {
        return $this->role->all();
    }
    public function paginate(int $page):PaginatorAdapter
    {
        return $this->role->paginate($page);
    }
    public function findById(int $id):Role
    {
        return $this->role->findById($id);
    }
    public function create(array $data):Role
    {
        return $this->role->create($data);
    }
    public function update(int $id,array $data):Role
    {
        return $this->role->update($id,$data);
    }
    public function destroy(int $id):bool
    {
        return $this->role->destroy($id);
    }

}
