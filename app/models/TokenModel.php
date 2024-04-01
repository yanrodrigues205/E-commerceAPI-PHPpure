<?php
    namespace models;
    use repositories\TokenRepository;

    class TokenModel extends TokenRepository
    {
        public function __construct()
        {

        }


        public function verify(string $token)
        {
            return self::validateToken($token);
        }
    }