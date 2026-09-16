<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $page = 10;
    public function perPage()
    {
        return $this->page;
    }
}
