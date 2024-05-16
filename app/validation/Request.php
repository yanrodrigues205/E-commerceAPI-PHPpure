<?php
    namespace validation;
    use utils\BodyRequest;
    use utils\GlobalConstants;
    use controllers\TokenController;
    class Request
    {
        private $request;
        private object $token_controller;
        private $body_request = [];
        const GET = 'GET';
        const DELETE = 'DELETE';
        public function __construct($request)
        {
            $this->request = $request;
            $this->token_controller = new TokenController();

        }

        public function processRequest()
        {
            $retorno = utf8_encode(GlobalConstants::MSG_ROUTE_ERROR);

            if(in_array($this->request['method'], GlobalConstants::REQUEST_TYPE, true)) //checked method is authorized
            {
                $retorno = $this->redirectRequest();
            }
            return $retorno;
        }

        private function redirectRequest()
        {
            if($this->request['method'] !== self::GET)
            {
                $this->body_request = BodyRequest::menageRequestBody();
            }
            $authorization = getallheaders()['Authorization'] ? getallheaders()['Authorization'] : "empty"; // BEARER Authorization

            $free_controllers = [ "USERS", "PRODUCTS"];
            $free_methods = ["GETALL", "ADD", "SIGNIN"];
            $verify = false;
            
            if(!in_array($this->request['route'], $free_controllers) || !in_array($this->request['resource'], $free_methods))
            {
                $this->token_controller->verifyToken($authorization);
            }

            // $this->request["method"];
            self::callController();
            
        }

        private function callController() : void
        {
            $controller = ucfirst(strtolower($this->request['route']));
            $controller_name =  $controller . "Controller";
            $controller = "controllers\\".$controller_name;

            if(class_exists($controller))
            {
                $method = $this->request['resource'];
                $obj = new $controller($this->body_request);
                
                if(method_exists($obj, $method))
                {
                    $call = $obj->$method($this->request['method']);
                }
                else
                {
                    header("HTTP/1.0 404 Not Found");
                    $message = [
                        "message" => "This route does not exist within the application!",
                        "status" => 404
                    ];
                    echo json_encode($message);
                    exit;
                }
            }
            else
            {
                header("HTTP/1.0 404 Not Found");
                $message = [
                    "message" => "This route does not exist within the application!",
                    "status" => 404
                ];
                echo json_encode($message);
                exit;
            }
        }
    }