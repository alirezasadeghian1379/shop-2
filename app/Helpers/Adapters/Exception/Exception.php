<?php
namespace App\Helpers\Adapters\Exception;

class Exception extends \Exception implements ExceptionAdapter
{
    public function __construct(
        string $message,
        int $code = 400,
        public array $data = []
    ) {
        parent::__construct($message, $code);
    }
}
