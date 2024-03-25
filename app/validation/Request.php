<?php
    namespace validation;
    use utils\BodyRequest;
    use utils\GlobalConstants;
    use repositories\TokenRepository;

    class Request
    {
        private $request;
        private object $token_repository;
        private mixed $body_request;
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
            if($this->request['method'] !== self::GET && $this->request['method'] !== self::DELETE)
            {
                $this->body_request = BodyRequest::menageRequestBody();
            }
            $authorization = getallheaders()['Authorization'] ? getallheaders()['Authorization'] : " ";
            $this->token_repository->validateToken($authorization);

        }
    }