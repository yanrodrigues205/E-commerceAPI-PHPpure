<?php
    namespace controllers;
    use models\ProductsModel;
    class ProductsController
    {
        private object $product_model;

        public function __construct()
        {
            $this->product_model = new ProductsModel();
        }
        public function getall()
        {
            $message = [
                "message" => "encontrou o controller na rota!"
            ];
            echo json_encode($message);
            exit;
        }
    }