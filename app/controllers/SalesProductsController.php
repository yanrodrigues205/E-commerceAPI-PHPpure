<?php
    namespace controllers;
    use models\SalesProductsModel;
    use services\ResponseService;
    use models\SalesModel;
    use models\ProductsModel;

    class SalesProductsController extends SalesProductsModel
    {
        private array $dados;
        private ProductsModel $products_model;

        private SalesModel $sales_model;
        private ?string $method;
        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->products_model = new ProductsModel();
            $this->sales_model = new SalesModel();
            parent::__construct();
        }

        public function insertSales($request_method) : void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if($this->dados['amount'] <= 0)
            {
                ResponseService::send(
                    "The minimum quantity for purchasing a product is one unit!",
                    400
                );
            }

            $verifyProduct_id = $this->products_model->existsProduct($this->dados['product_id']);

            if(!$verifyProduct_id)
            {
                ResponseService::send(
                    "Invalid Product Identification!",
                    400
                );
            }


            $verifySales_id = $this->sales_model->getOneSalesByID($this->dados['sales_id']);

            if(!$verifySales_id)
            {
                ResponseService::send(
                    "Invalid Product Identification!",
                    400
                );
            }

            $insert = self::insertSalesProducts($this->dados['product_id'], $this->dados['sales_id'], $this->dados['amount']);

            if(!$insert)
            {
                ResponseService::send(
                    "Unable to insert sale item!",
                    422
                );
            }

            ResponseService::send(
                "Another item for sale has been added whose ID is => ".$this->dados['sales_id'],
                202
            );


        }

        private function verifyMethod(string $request_method,string $method) : void
        {
            if($request_method != $method)
            {
                ResponseService::send(
                    "This route does not exist with the method used!",
                    405
                );
            }
        }

    }
?>