<?php
    namespace services\coupon;

    use Exception;

    abstract class DiscountCouponService
    {
        /**
         *  MÉTODO TEMPLATE FEITO PARA CALCULAR DESCONTOS NO SISTEMA
         *  O MESMO DEFINE O FLUXO DE CÁLCULO E DELEGA PARTES AS SUBCLASSES.
         * @param float $total
         * @return float
         */
        public function calculateDiscount(float $total) : float
        {
            if(!$this->isValid($total))
            {
                //printf("\nEste cupom não está em condições válidas.");
                return $total; //SE NÃO FOR VÁLIDO RETORNA O  VALOR NORMAL
            }

            return $this->applyDiscount($total);
        }


        protected function isValid(float $total) : bool
        {
            return true;
        }


        abstract protected function applyDiscount(float $total) : float;
    }