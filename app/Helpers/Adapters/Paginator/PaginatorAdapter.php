<?php

namespace App\Helpers\Adapters\Paginator;

use Illuminate\Support\Collection;

abstract class PaginatorAdapter
{
    public array $items;
    public int $perPage;
    public int $currentPage;
    public int $total;
    public int $lastPage;

    abstract public function firstItem();
    abstract public function render();
    abstract public function onEachSide($i);

}
