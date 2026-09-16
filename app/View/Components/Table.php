<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public array $headers;
    public $items;
    public $isPaginate;

    /**
     * Create a new component instance.
     */
    public function __construct($headers,$items,$isPaginate = true)
    {
        $this->headers = $headers;
        $this->items = $items;
        $this->isPaginate = $isPaginate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
