<?php
    namespace models;
    use repositories\ProductRepository;

    class ProductsModel
    {
        private object $repository;

        public function __construct()
        {
            $this->repository = new ProductRepository();    
        }

        public function getall() : array
        {
            return $this->repository->getAllProducts();
        }

        public function insert(string $name, string $description, string $value, int $amount, string $img_path) :mixed
        {
            if(getimagesize($img_path))
            {
                $get_image = file_get_contents($img_path);
                $extension = pathinfo($img_path, PATHINFO_EXTENSION);
                $base64 = base64_encode($get_image);
                $encoded = "data:image/" . $extension . ";base64," . $base64;

                $data = [
                    "name" => $name,
                    "description" => $description,
                    "value" => $value,
                    "amount" => $amount,
                    "img_path" => $encoded
                ];

                return $this->repository->insertProduct($data); 
            }
            else
            {
                return false;
            }
        }



        public function existsProduct(int $id) : bool
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
    }