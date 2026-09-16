<?php

namespace App\Services;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Admin\IAdminRepository;
use App\Repositories\Admin\Models\Admin;
use Illuminate\Support\Collection;

class AdminService {
    public function __construct(
        protected IAdminRepository $admin
    ) {}
    public function all():Collection
    {
        return $this->admin->all();
    }
    public function paginate(int $perPage):PaginatorAdapter
    {
        return $this->admin->paginate($perPage);
    }
    public function create(array $data):Admin
    {
        return $this->admin->create($data);
    }
    public function findById(int $id):?Admin
    {
        return $this->admin->findById($id);
    }
    public function update(int $id,array $data):Admin
    {
        return $this->admin->update($id,$data);
    }
    public function destroy(int $id):bool
    {
        return $this->admin->destroy($id);
    }
}
