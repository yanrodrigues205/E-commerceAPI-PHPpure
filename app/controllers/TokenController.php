<?php
    namespace controllers;
    use models\TokenModel;
    class TokenController
    {
        private $token_model;
        public  function __construct() {
            $this->token_model = new TokenModel();
        }


        public function verifyToken(string $token) : void
        {
            $token = str_replace([" ", "Bearer"], "", $token);

            if(!empty($token) && $token !== "empty")
            {
                $result = $this->token_model->verify($token);

                if(count($result) !== 1 OR $result == false)
                {
                    header("HTTP/1.1 401 Unauthorized");
                    $response = [
                        "message" => "NAO AUTORIZADO!",
                        "status" => 401
                    ];
                    echo json_encode($response);
                    exit;
                }
            }
            else
            {
                header("HTTP/1.1 401 Unauthorized");
                $response = [
                    "message" => "You sent something invalid or left the access token empty!",
                     "status" => 401
                ];
                echo json_encode($response);
                exit;
            }
        }
    }