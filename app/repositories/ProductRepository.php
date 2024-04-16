<?php
    namespace repositories;
    use database\MySql;
    use Exception;

    class ProductRepository
    {
        private string $table = 'products';
        private object $database;

        public function __construct()
        {
            $this->database = new MySql();
        }

        /**
         * @return MySql|object
         */

        public function getDB() : object
        {
            return $this->database;
        }


        public function getAllProducts() : array
        {
            $query = "SELECT * FROM " . $this->table;

            try
            {
                $db = $this->database->getDB();
                $prepare = $db->query($query);
                $all = $prepare->fetchAll($db::FETCH_ASSOC);    
                return $all;
            }
            catch(Exception $err)
            {
                return [
                    "message" => "Error when searching for all '".$this->table."' ",
                    "error" => $err
                ];
            }    

            
        }


        /**
         * @param array $data
         * @return array $result
         */

        public function insertProduct(array $data) : mixed
        {
            $query = "INSERT INTO " . $this->table . "(name, description, value, amount, img_path) VALUES (:name, :description, :value, :amount, :img_path) ";

            try
            {
                $db = $this->database->getDB();
                $prepare = $db->prepare($query);
                $prepare->bindParam(":name", $data["name"]);
                $prepare->bindParam(":description", $data["description"]);
                $prepare->bindParam(":value", $data["value"]);
                $prepare->bindParam(":amount", $data["amount"]);
                $prepare->bindParam(":img_path", $data["img_path"]);
                $result = $prepare->execute();
                return $result;

            }
            catch(Exception $err)
            {
                echo "New exception in ProductRepository, Exception => ".$err;
                
            }


        }
    }