<?php

namespace App\Repositories\PaymentGateWay\Models;

class PaymentCallbackDto
{
    public function __construct(
        public string $authority,
        public bool $isSuccess,
        public ?string $status,
    ) {}
}
