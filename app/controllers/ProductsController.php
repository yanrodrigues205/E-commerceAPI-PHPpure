<?php
    namespace controllers;
    use models\ProductsModel;
    class ProductsController extends ProductsModel
    {
        private $dados;

        private ?string $method;

        public function __construct($dados = [])
        {
            $this->dados = $dados;
            parent::__construct();
        }


        /**
         * @param string $request_method = GET|POST|PUT|DELETE...
         */

        public function getall($request_method) : void
        {
            $this->method = "GET";
            self::verifyMethod($request_method, $this->method);

            $get = self::AllProducts();
            echo json_encode($get);

        }

        public function insert($request_method) : void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados['name']) || empty($this->dados['description']) || empty($this->dados['value']) || empty($this->dados['amount']) || empty($this->dados['img_path']))
            {
                header("HTTP/1.1 400 Bad Request");
                $message = [
                    "message" => "To complete the precise insertion of the fields (name, description, value, amount, img_path).",
                    "status" => 400
                ];
            }
            else
            {
                $result = self::insertProduct($this->dados['name'], $this->dados['description'], $this->dados['value'], intval($this->dados['amount']), $this->dados['img_path']);

                if($result)
                {
                    header('HTTP/1.1 200 OK');
                    $message = [
                        "message" => "Product added successfully!",
                        "status" => 200
                    ];
                }
                else
                {
                    header('HTTP/1.1 422 Unprocessable Entity');
                    $message = [
                        "message" => "Unable to complete product registration!",
                        "status" => 422
                    ];
                }
            }

            echo json_encode($message);
            exit;
            
           
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