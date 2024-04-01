<?php
    namespace validation;
    use controllers\ProductsController;
    use utils\BodyRequest;
    use utils\GlobalConstants;
    use repositories\TokenRepository;

    class Request
    {
        private $request;
        private object $token_repository;
        private $body_request = [];
        const GET = 'GET';
        const DELETE = 'DELETE';
        public function __construct($request)
        {
            $this->request = $request;
            $this->token_repository = new TokenRepository();

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

            if($this->request['route'] != "PRODUCTS" && $this->request['resourse'] != "GETALL")
            {
                $this->token_repository->validateToken($authorization);
            }

            $this->request["method"];
            self::callController();
            
        }

        private function callController() : void
        {
            $controller = ucfirst(strtolower($this->request['route']));
            $controller_name =  $controller . "Controller";
            $sla = __DIR__ ."/../controllers/". $controller_name . ".php";
            $file = $sla;
            if(file_exists($file))
            {
                $controller = "controllers\\".$controller_name;
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
        }
    }