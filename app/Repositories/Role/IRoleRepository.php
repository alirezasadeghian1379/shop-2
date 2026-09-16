<?php

namespace App\Repositories\Role;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Role\Models\Role;
use Illuminate\Support\Collection;

interface IRoleRepository {
    public function all(): Collection;
    public function paginate(int $perPage) :PaginatorAdapter;
    public function findById(int $id):Role;
    public function create(array $data):Role;
    public function update(int $id,array $data):Role;
    public function destroy(int $id):bool;
}
