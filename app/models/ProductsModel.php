<?php
    namespace models;
    use PDO;
    use database\MySql;
    use Exception;

    class ProductsModel
    {
        private PDO $database;
        private string $table;

        public function __construct()
        {
            /**
             * @name {MySql} - connection to database
             * @value singleton connector
             * @default MySql
             */
            $this->database = MySql::getInstance()->getConnector();
 
            /**
             * @var string - table, reference to database
             */
            $this->table = "products";
        }

        protected function AllProducts() : array
        {
            $query = "SELECT * FROM " . $this->table;

            try
            {
                $prepare = $this->database->query($query);
                $all = $prepare->fetchAll($this->database::FETCH_ASSOC);
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

        protected function insertProduct(string $name, string $description, string $value, int $amount, string $img_path) : bool
        {
            $query = "INSERT INTO " . $this->table . "(name, description, value, amount, img_path) VALUES (:name, :description, :value, :amount, :img_path) ";

            try
            {
                $prepare = $this->database ->prepare($query);
                $prepare->bindParam(":name", $name);
                $prepare->bindParam(":description", $description);
                $prepare->bindParam(":value", $value);
                $prepare->bindParam(":amount", $amount);
                $prepare->bindParam(":img_path", $img_path);
                $result = $prepare->execute();
                return $result;

            }
            catch(Exception $err)
            {
                echo "New exception in ProductRepository, Exception => ".$err;
                return false;
            }
        }

        public function existsProduct(int $id) : mixed
        {
            $query = "SELECT * FROM `".$this->table."` WHERE id = :id ";
            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();
                $all = $prepare->fetchAll($this->database::FETCH_ASSOC);

                if(count($all) > 0)
                    return true;
                else
                    return false;
            }
            catch(Exception $err)
            {
                echo "New exception in ProductRepository, Exception => ".$err;
                return false;
            }
        }
    }