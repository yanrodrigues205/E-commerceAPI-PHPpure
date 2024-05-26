<?php
    namespace controllers;
    use models\TokenModel;
    use services\ResponseService;
    class TokenController extends TokenModel
    {
        public  function __construct()
        {
            parent::__construct();
        }


        public function verifyToken(string $token) : void
        {
            $token = str_replace([" ", "Bearer"], "", $token);

            if(!empty($token) && $token !== "empty")
            {
                $result = self::verify($token);

                if(count($result) !== 1 OR $result == false)
                {
                    ResponseService::send(
                        "Session expired, try logging in again, we are sorry for the inconvenience.",
                        401
                    );
                }
            }
            else
            {
                ResponseService::send(
                    "You sent something invalid or left the access token empty!",
                    401
                );
            }
        }

    }