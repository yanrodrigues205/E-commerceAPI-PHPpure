<?php
    namespace models;
    use repositories\TokenRepository;
    use services\UUIDService;

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


        public function insert(int $user_id)
        {
            return  $this->repository->insertToken(UUIDService::create(), $user_id);
        }
    }