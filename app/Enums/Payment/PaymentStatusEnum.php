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
            self::INITIATED => __('dashboard::app.enums.paymentStatus.initiated_text'),
            self::PENDING => __('dashboard::app.enums.paymentStatus.pending_text'),
            self::PAID => __('dashboard::app.enums.paymentStatus.paid_text'),
            self::FAILED => __('dashboard::app.enums.paymentStatus.failed_text'),
            self::CANCELLED => __('dashboard::app.enums.paymentStatus.cancelled_text'),
            self::REFUNDED => __('dashboard::app.enums.paymentStatus.refunded_text'),
        ];
    }
    public static function getStatusesColor() :array
    {
        return [
            self::INITIATED => __('dashboard::app.enums.paymentStatus.initiated_color'),
            self::PENDING => __('dashboard::app.enums.paymentStatus.pending_color'),
            self::PAID => __('dashboard::app.enums.paymentStatus.paid_color'),
            self::FAILED => __('dashboard::app.enums.paymentStatus.failed_color'),
            self::CANCELLED => __('dashboard::app.enums.paymentStatus.cancelled_color'),
            self::REFUNDED => __('dashboard::app.enums.paymentStatus.refunded_color'),
        ];
    }

}
