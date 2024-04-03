<?php
    namespace models;
    use repositories\TokenRepository;

    class TokenModel
    {
        private $repository;
        public function __construct()
        {
            $this->repository = new TokenRepository();
        }


        public function verify(string $token)
        {
            return $this->repository->validateToken($token);
        }
    }