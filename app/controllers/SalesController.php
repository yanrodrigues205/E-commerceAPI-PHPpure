<?php
    namespace controllers;
    use models\SalesProductsModel;
    use models\ProductsModel;
    use models\SalesModel;
    use models\UsersModel;
    use services\ResponseService;
    class SalesController extends SalesModel
    {
        private ProductsModel $products_model;
        private SalesProductsModel $sales_products_model;
        private UsersModel $users_model;
        private $dados;

        private ?string $method;

        public  function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->sales_products_model = new SalesProductsModel();
            $this->products_model = new ProductsModel();
            $this->users_model = new UsersModel();
            parent::__construct();

        }


        public function insert_sale($request_method) : void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados['user_id']))
            {
                ResponseService::send(
                    "To complete the precise insertion of the fields (user_id).",
                    400
                );
            }
            $verifyUser = $this->users_model->getUserByID($this->dados['user_id']);

            if(!$verifyUser)
            {
                ResponseService::send(
                    "This user does not exist within the system!",
                    422
                );
            }



            $insert = self::insert($this->dados['user_id']);

            if(!$insert)
            {
                ResponseService::send(
                    "We were unable to enter the sale!",
                    400
                );
            }

            ResponseService::send(
                "Sale started successfully!",
                200
            );


        }


        public function insert_sales_product($request_method) : void
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


            $verifySales_id = self::existsSales($this->dados['sales_id']);

            if(!$verifySales_id)
            {
                ResponseService::send(
                    "Invalid Product Identification!",
                    400
                );
            }

            $insert = $this->sales_products_model->insert($this->dados['product_id'], $this->dados['sales_id'], $this->dados['amount']);

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