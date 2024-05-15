<?php
    namespace models;
    use repositories\UserRepository;

    class UsersModel
    {
        private object $repository;
        public function __construct()
        {
            $this->repository = new UserRepository();
        }

        public function insert(string $name, string $email, string $password)
        {
            $password = md5($password);
            $data = [
                "name" => $name,
                "email" => $email,
                "password" => $password
            ];

            
            return $this->repository->insertUser($data);

        }

        public function existsEmail(string $email) : bool
        {
            return $this->repository->existsEmail($email);
        }

        public function verifyingCredentials(string $email, string $password)
        {
            $data = [
                "email" => $email,
                "password" => md5($password)
            ];

            return $this->repository->verifyUser($data);
        }

    }