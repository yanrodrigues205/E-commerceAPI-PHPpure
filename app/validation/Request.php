<?php
    namespace validation;

    class Request
    {
        private array $request;
        public function __construct($request)
        {
            $this->request = $request;
        }

        public function processRequest()
        {

        }
    }
?>