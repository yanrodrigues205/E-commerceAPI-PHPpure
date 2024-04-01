<?php
    namespace controllers;
    use models\ProductsModel;
    class ProductsController
    {
        private object $product_model;
        private $dados;

        private ?string $method;

        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->product_model = new ProductsModel();
        }


        /**
         * @param string $method = GET|POST|PUT|DELETE...
         */
        
        public function getall($request_method) : void
        {
            $this->method = "GET";
            self::verifyMethod($request_method, $this->method);
                
            $get = $this->product_model->getall();
            echo json_encode($get);

        }

        public function insert($request_method) : void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            echo json_encode([
                "message" => "chegou no controller certo, metodo POST e está com tokem de autorização",
                "status" => 202
            ]);
        }


        private function verifyMethod(string $request_method,string $method) : void
        {
            if($request_method != $method)
            {
                header("HTTP/1.0 405 Not Found");
                    $message = [
                        "message" => "This route does not exist with the method used!",
                        "status" => 405
                    ];
                echo json_encode($message);
                exit;
            }
        }
    }