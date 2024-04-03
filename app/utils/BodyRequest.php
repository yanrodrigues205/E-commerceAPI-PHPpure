<?php
    namespace utils;
    use JsonException as JsonExceptionAlias;

    class BodyRequest
    {

        /**
         * @return array|mixed
         */
        public static function menageRequestBody()
        {
            try
            {
                $request_body = json_decode(file_get_contents('php://input'), true);
            }
            catch(JsonExceptionAlias $e)
            {
                throw new \InvalidArgumentException("The request body connot be empty!");
            }


            if(is_array($request_body) && count($request_body) > 0)
            {
                return $request_body;
            }
        }
    }