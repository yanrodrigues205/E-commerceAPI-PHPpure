<?php

    namespace services\coupon;

    class PercentageDiscount extends DiscountCouponService
    {
        private float $percentage;

        public function __construct(int $percentage)
        {
            $this->percentage = $percentage;
        }
        public function applyDiscount(float $total) : float
        {
            $discount = ( $total * $this->percentage / 100 );
            $calc = ( $total - $discount );

            //printf("\nApós o desconto de porcentagem '{$this->percentage}%' o valor ficou em R$ {$calc}");

            return $calc;
        }
    }