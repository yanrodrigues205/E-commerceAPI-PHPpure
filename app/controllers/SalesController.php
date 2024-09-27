<?php
    namespace controllers;
    use models\SalesModel;
    use models\UsersModel;
    use services\ResponseService;
    class SalesController extends SalesModel
    {
        private UsersModel $users_model;
        private $dados;

        private ?string $method;

        public  function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->users_model = new UsersModel();
            parent::__construct();

        }


        public function init($request_method) : void
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



            $insert = self::initSales($this->dados['user_id']);

            if(!$insert)
            {
                ResponseService::send(
                    "We were unable to enter the sale!",
                    400
                );
            }


            header("HTTP/1.1 200 OK");
            $message = [
                "message" => "Sale started successfully!",
                "id" => $insert,
                "status" => 200
            ];
            echo json_encode($message);
            exit;
        }


        public function end($request_method)
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);
            

            if(empty($this->dados["sales_id"]) || $this->dados["sales_id"] <= 0 || empty($this->dados["payment"]))
            {
                ResponseService::send(
                    "To complete the precise insertion of the fields (sales_id, payment).",
                    400
                );
            }

            $finish = self::endSales($this->dados["sales_id"], $this->dados["payment"]);

            if(!$finish)
            {
                ResponseService::send(
                    "We were unable to end the sale!",
                    400
                );
            }

            ResponseService::send(
                "Sale completed successfully!",
                200
            );
        }


       public function getall(string $request_method)
       {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);


            $get = self::getAllSales();
            if(!$get || count($get) <= 0)
            {
                ResponseService::send(
                    "No available sales found",
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