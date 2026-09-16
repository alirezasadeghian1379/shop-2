<?php
namespace App\Repositories\PaymentGateWay\Models;

class PaymentGateWayResult
{
    public ?int $statusCode;
    public ?string $message;
    public ?int $ref_id;
    public ?string $card_pan;
    public ?int $fee;

    public function __construct(?int $statusCode,?string $message, ?int $ref_id, ?string $card_pan, ?int $fee)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->ref_id = $ref_id;
        $this->card_pan = $card_pan;
        $this->fee = $fee;
    }

}
