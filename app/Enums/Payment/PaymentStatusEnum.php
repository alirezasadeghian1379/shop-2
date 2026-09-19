<?php

namespace App\Enums\Payment;

enum PaymentStatusEnum
{

    const INITIATED = 'INITIATED';
    const PENDING = 'PENDING';
    const PAID = 'PAID';
    const FAILED = 'FAILED';
    const CANCELLED = 'CANCELLED';
    const REFUNDED = 'REFUNDED';

    public static function getStatuses():array
    {
        return array(self::INITIATED,self::PENDING,self::PAID,self::FAILED,self::CANCELLED,self::REFUNDED);
    }

    public static function getStatusesDescription() :array
    {
        return [
            self::INITIATED => 'درخواست ایجاد شده',
            self::PENDING => 'در انتظار تایید',
            self::PAID => 'پرداخت موفق',
            self::FAILED => 'پرداخت ناموفق',
            self::CANCELLED => 'لغو توسط کاربر',
            self::REFUNDED => 'برگشت خورده',
        ];
    }
    public static function getStatusesColor() :array
    {
        return [
            self::INITIATED => 'warning',
            self::PENDING => 'warning',
            self::PAID => 'success',
            self::FAILED => 'danger',
            self::CANCELLED => 'danger',
            self::REFUNDED => 'danger',
        ];
    }

}
