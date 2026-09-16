<?php

namespace App\Helpers\Adapters\Exception;

interface ExceptionAdapter
{
    public function getCode();
    public function getMessage(): string;
}
