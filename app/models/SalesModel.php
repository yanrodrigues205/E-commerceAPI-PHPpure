<?php
    namespace models;
    use repositories\SalesRepository;

    class SalesModel
    {
        private $repository;

        public function __construct()
        {
            $this->repository = new SalesRepository();
        }

        public function existsSales(int $id) 
        {
            $verify = $this->repository->getOneByID($id);

            if(count($verify) == 1)
            {
                return true;
            }
            else
            {
                return false; 
            }
        }

        public function insert(int $user_id) 
        {
            $data = [
                "user_id" => $user_id
            ];

            return $this->repository->insertSales($data);
        }
    }