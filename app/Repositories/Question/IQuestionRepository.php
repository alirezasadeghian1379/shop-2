<?php

namespace App\Repositories\Question;

use App\Helpers\Adapters\Paginator\PaginatorAdapter;
use App\Repositories\Question\Models\Question;
use Illuminate\Support\Collection;

interface IQuestionRepository
{
    public function all():Collection;
    public function getActiveAll():Collection;
    public function paginate(int $perPage):PaginatorAdapter;
    public function findById(int $id):Question;
    public function create(array $data):bool;
    public function update(int $id,array $data):bool;
    public function destroy(int $id):bool;
}
