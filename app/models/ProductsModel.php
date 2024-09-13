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

        protected function updateProduct(int $product_id, string | false $name, string | false $description, string | false $value, int | false $amount, string | false $img_path) : bool
        {
            $data = [];

            if(!empty($name) && $name !== false)
            {
                $data["name"] = $name;
            }

            if(!empty($description) && $description !== false)
            {
                $data["description"] = $description;
            }

            if(!empty($value) && $value !== false)
            {
                $data["value"] = $value;
            }

            if(!empty($amount) && $amount !== false)
            {
                $data["amount"] = $amount;
            }

            if(!empty($img_path) && $img_path !== false)
            {
                $data["img_path"] = $img_path;
            }

            $query = "UPDATE ".$this->table." SET ";

            $i =0;

            foreach($data as $key_array => $value_array)
            { 
                if($i > 0)
                    $query .= " ,";
                $query .= $key_array." = :".$key_array;
                $i++;
            }

            $query .= " WHERE id = :id";
            try
            {
                $prepare = $this->database ->prepare($query);

                foreach($data as $key_array => $value_array)
                {
                    $prepare->bindValue(":".$key_array, $value_array);
                }
                $prepare->bindValue(":id", $product_id);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in ProductsModel => ".$err;
                return false;
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
                //echo "New exception in ProductRepository, Exception => ".$err;
                return false;
            }
        }

        protected function deleteProductByID(int $id)
        {
            $query = "DELETE FROM `".$this->table."` WHERE id = :id";
            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $result = $prepare->execute();

                if($result)
                    return true;
                else
                    return false;
            }
            catch(Exception $err)
            {
                //echo "New exception in ProductRepository, Exception => ".$err;
                return false;
            }
        }


    }