<?php
    namespace controllers;
    use models\UsersModel;
    use models\TokenModel;
    use services\ResponseService;

    class UsersController
    {
        private object $user_model;
        private object $tokens_model;
        private $dados;
        private ?string $method;

        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->user_model = new UsersModel();
            $this->tokens_model = new TokenModel();
        }

        /**
         * @param string $request_method = GET|POST|PUT|DELETE...
         */

        public function add($request_method) : void
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

        public function signin($request_method):void
        {
            $this->method = "POST";
            self::verifyMethod($request_method, $this->method);

            if(empty($this->dados['email']) || empty($this->dados['password']))
            {
                ResponseService::send(
                    "Fill in all fields to log in (email and password)",
                    422
                );
            }

            $verifyCredentials = $this->user_model->verifyingCredentials($this->dados['email'], $this->dados['password']);

            if(!$verifyCredentials)
            {
                ResponseService::send(
                    "Email or password are invalid, try again!",
                    422
                );
            }


            if(empty($verifyCredentials[0]->id))
            {
                ResponseService::send(
                    "Email or password are invalid, try again!",
                    422
                );
            }
        
            $create_token = $this->tokens_model->insert($verifyCredentials[0]->id);

            if($create_token)
            {
                header("HTTP/1.1 200 OK");
                $message = [
                    "message" => "User logged in successfully!",
                    "status" => 200,
                    "token" => $create_token
                ];
                echo json_encode($message);
                exit;

            }
            else
            {
                ResponseService::send(
                    "Internal token creation error",
                    422
                );
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