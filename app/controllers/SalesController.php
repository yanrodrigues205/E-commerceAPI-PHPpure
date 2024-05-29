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


        public function insert($request_method) : void
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



            $insert = self::insertSales($this->dados['user_id']);

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