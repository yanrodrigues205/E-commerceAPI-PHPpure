<?php
    namespace models;
    use repositories\ProductRepository;

    class ProductsModel
    {
        private object $repository;

        public function __construct()
        {
            $this->repository = new ProductRepository();    
        }

        public function getall() : array
        {
            return $this->repository->getAllProducts();
        }
    }