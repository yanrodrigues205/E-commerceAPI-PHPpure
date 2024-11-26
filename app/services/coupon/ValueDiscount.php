<?php

    namespace services\coupon;

use Exception;

    class ValueDiscount extends DiscountCouponService
    {
        private float $discount;

        public function __construct(float $value_discount)
        {
            $this->discount = $value_discount;
        }
        public function applyDiscount(float $total) : float
        {
            if($total <= 300)
            {
                throw new Exception("\nNão foi possível aplicar o cupom de desconto pois não atingiu o valor mínimo.");
            }

            $calc = max(0, $total - $this->discount);

            //printf("\nApós o desconto de R$ {$this->discount} o valor ficou em R$ {$calc}");

            return $calc;

        }
    }