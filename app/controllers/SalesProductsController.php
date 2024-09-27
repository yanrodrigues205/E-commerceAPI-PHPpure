<?php
    namespace controllers;
    use models\SalesProductsModel;
    use services\ResponseService;
    use models\SalesModel;
    use models\ProductsModel;
    use controllers\ProductsController;

    class SalesProductsController extends SalesProductsModel
    {
        private array $dados;

        private SalesModel $sales_model;
        private ProductsController $products_controller;
        private ?string $method;
        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->sales_model = new SalesModel();
            $this->products_controller = new ProductsController();
            parent::__construct();
        }

        public function insert(string $request_method) : void
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

            
            $data = array("product_id" => $this->dados["product_id"]);
            $this->products_controller->setData($data);
            $verifyProduct_id = $this->products_controller->getone("GET", true);

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

            header("HTTP/1.1 200 OK");
            $message = [
                "message" => "Another item for sale has been added whose ID is => ".$this->dados['sales_id'],
                "id" => $insert,
                "status" => 200
            ];
            echo json_encode($message);
            exit;
        }


        public function getall($request_method)
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados["sales_id"]) || $this->dados["sales_id"] <= 0)
            {
                ResponseService::send(
                    "For this operation a sales ID is required",
                    422
                );
            }

            $get =  self::getAllSalesProductBySalesID($this->dados["sales_id"]);


            for($i = 0; $i < count($get); $i++)
            {
                $data = array("product_id" => $get[$i]["product_id"]);
                $this->products_controller->setData($data);
                $product = $this->products_controller->getone("GET", true);
                $sum_of_values = $product["value"] * $get[$i]["amount"];
                $get[$i]["product_name"] = $product["name"];
                $get[$i]["product_description"] = $product["description"];
                $get[$i]["product_value"] = $product["value"];
                $get[$i]["product_sum_of_values"] = $sum_of_values;
            }

            if(count($get) <= 0)
            {
                ResponseService::send(
                    "No items found for sale!",
                    422
                );
            }

            echo json_encode($get);
            exit;
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