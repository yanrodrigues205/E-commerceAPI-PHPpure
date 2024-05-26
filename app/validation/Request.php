<?php
    namespace validation;
    use utils\BodyRequest;
    use utils\GlobalConstants;
    use controllers\TokenController;
    use factories\ControllerFactory;
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

            if(!in_array($this->request['route'], $free_controllers) || !in_array($this->request['resource'], $free_methods))
            {
                $this->token_controller->verifyToken($authorization);
            }

            ControllerFactory::callController($this->request["route"], $this->request["resource"],$this->request["method"], $this->body_request);
        }
    }