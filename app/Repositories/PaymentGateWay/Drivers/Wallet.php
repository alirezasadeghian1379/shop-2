<?php

namespace App\Repositories\PaymentGateWay\Drivers;

use App\Enums\Payment\PaymentGateWayTypeEnum;
use App\Helpers\Adapters\Exception\Exception;
use App\Repositories\PaymentGateWay\Contracts\IPaymentWallet;
use App\Models\User as UserModel;

class Wallet implements IPaymentWallet
{
    public function payWithWallet(float $amount,string $description): bool
    {
        $user = UserModel::where('id',auth('api')->id())->first();
        if (!$user)  throw new Exception('اطلاعاتی یافت نشد!',404);
        $tomanWallet = $user->tomanWallet;
        if ($amount > $tomanWallet->amount) throw new Exception('موجودی کیف پول کافی نمیباشد.',422);
        return true;
    }

    public function getName(): string
    {
        return PaymentGateWayTypeEnum::WALLET;
    }
}
