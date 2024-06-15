<?php
    namespace controllers;
    use models\ProductsModel;
    use services\ResponseService;
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
                ResponseService::send(
                    "To complete the precise insertion of the fields (name, description, value, amount, img_path).",
                    400
                );
            }
            else
            {
                $result = self::insertProduct($this->dados['name'], $this->dados['description'], $this->dados['value'], intval($this->dados['amount']), $this->dados['img_path']);

                if($result)
                {
                    ResponseService::send(
                        "Product added successfully!",
                        200
                    );
                }
                else
                {
                    ResponseService::send(
                        "Unable to complete product registration!",
                        422
                    );
                }
            }
        }

        public function update(string $request_method) : void
        {
            $this->method = "PUT";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados["id"]))
            {
                ResponseService::send(
                    "The product ID is required to complete the operation",
                    400
                );
            }

            if(empty($this->dados["name"]) && empty($this->dados["description"]) && empty($this->dados["value"]) && empty($this->dados["amount"]) && empty($this->dados["img_path"]))
            {
                ResponseService::send(
                    "To make changes you need to change at least one element of a product!",
                    400
                );
            }

            $result = self::updateProduct($this->dados["id"], $this->dados["name"], $this->dados["description"], $this->dados["value"], $this->dados["amount"], $this->dados["img_path"]);

            if(!$result)
            {
                ResponseService::send(
                    "Unable to change product!",
                    422
                );
            }

            ResponseService::send(
                "Product has been changed successfully!",
                200
            );
        }

        public function delete(string $request_method) : void
        {
            
            $this->method = "DELETE";
            self::verifyMethod($request_method, $this->method);
            
            if(empty($this->dados["id"]))
            {
                ResponseService::send(
                    "The product ID is required to complete the operation",
                    400
                );
            }

            $verify_id = self::existsProduct($this->dados["id"]);

            if(!$verify_id)
            {
                ResponseService::send(
                    "There is not product with this ID!",
                    400
                );
            }

            $delete = self::deleteProductByID($this->dados["id"]);

            if(!$delete)
            {
                ResponseService::send(
                    "Unable to demand product deletion!",
                    422
                );
            }

            ResponseService::send(
                "Product deleted successfully!",
                200
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