<?php
    namespace controllers;
    use models\UsersModel;
    use services\ResponseService;

    class UsersController
    {
        private object $user_model;
        private $dados;
        private ?string $method;

        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->user_model = new UsersModel();
        }

        /**
         * @param string $request_method = GET|POST|PUT|DELETE...
         */

        public function insert($request_method) : void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados['name']) || empty($this->dados['email']) || empty($this->dados['password']))
            {
                ResponseService::send(
                    "To complete the precise insertion of the fields (name, email, password).",
                    400
                );
            }
            else
            {
                $existsEmail = $this->user_model->existsEmail($this->dados['email']);
                
                if($existsEmail)
                {
                    ResponseService::send(
                        "This email already exists in the system!",
                        400
                    );
                }

                $insert = $this->user_model->insert($this->dados['name'], $this->dados['email'], $this->dados['password']);

                if($insert)
                {
                    ResponseService::send(
                        "User added successfully!",
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