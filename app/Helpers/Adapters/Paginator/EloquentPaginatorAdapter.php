<?php

namespace App\Helpers\Adapters\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPaginatorAdapter extends PaginatorAdapter
{
    private LengthAwarePaginator $paginator;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->items = $paginator->items();
        $this->perPage = $paginator->perPage();
        $this->lastPage = $paginator->lastPage();
        $this->currentPage = $paginator->currentPage();
        $this->total = $paginator->total();
        $this->paginator = $paginator;
    }

    public function firstItem()
    {
        return $this->paginator->firstItem();
    }

    public function render()
    {
        return $this->paginator->render();
    }

    public function onEachSide($i)
    {
        $this->paginator->onEachSide($i);
        return $this;
    }
    public function appends($key, $value = null): self
    {
        $this->paginator->appends($key, $value);
        return $this;
    }
}
