<?php

namespace App\Repositories\Admin;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Admin\Models\Admin;
use Illuminate\Support\Collection;

interface IAdminRepository {
    public function all():Collection;
    public function paginate(int $perPage): PaginatorAdapter;
    public function findById(int $id): ?Admin;
    public function create(array $data): Admin;
    public function update(int $id,array $data): Admin;
    public function destroy(int $id): bool;
}
