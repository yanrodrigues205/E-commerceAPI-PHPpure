<?php
    namespace models;
    use repositories\SalesProductsRepository;

    class SalesProductsModel
    {
        private $repository;

        public function __construct()
        {
            $this->repository = new SalesProductsRepository();
        }

        public function insert(int $product_id, int $sales_id, int $amount)
        {
            $data = [
                "product_id" => $product_id,
                "sales_id" => $sales_id,
                "amount" => $amount
            ];

            return $this->repository->insertSalesProducts($data);
        }

        
    }