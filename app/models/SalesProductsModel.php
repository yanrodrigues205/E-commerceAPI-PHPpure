<?php
    namespace models;
    use database\MySql;
    use PDO;
    use Exception;

    class SalesProductsModel
    {
        private PDO $database;
        private string $table;

        protected function __construct()
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
             $this->table = "sales_products";
        }

        protected function insertSalesProducts(int $product_id, int $sales_id, int $amount) : int | false
        {
            $query = "INSERT INTO `" .$this->table . "`
            ( product_id, sales_id, amount ) VALUES ( :product_id, :sales_id, :amount )";
            try
            {
                $result = $this->database->prepare($query);
                $result->bindParam(":product_id", $product_id);
                $result->bindParam(":sales_id", $sales_id);
                $result->bindParam(":amount", $amount);
                $results = $result->execute();

                $lastInsertId = $this->database->lastInsertId();

                return $lastInsertId ? (int)$lastInsertId : false;

            }
            catch(Exception $err)
            {
                echo "New Exeption Error in SalesProductsModel => ".$err;
                return false;
            }
        }

        protected function salesProductsUpdate(int | false $product_id, int | false $sales_id, int | false $amount, int | false $sales_products_id) : bool
        {
            $data =[];

            if(!empty($product_id) && !$product_id)
            {
                $data["product_id"] = $product_id;
            }

            if(!empty($amount) && !$amount)
            {
                $data["amount"] = $amount;
            }

            if(!empty($sales_id) && !$sales_id)
            {
                $data["sales_id"] = $sales_id;
            }

            $query = "UPDATE ".$this->table." SET ";

            $i =0;

            foreach($data as $key_array => $value_array)
            {
                if($i == 1)
                    $query .= " ,";
                $query .= $key_array." = :".$key_array;
                $i = 1;
            }

            $query .= " WHERE id = :id";
            try
            {
                $prepare = $this->database ->prepare($query);

                foreach($data as $key_array => $value_array)
                {
                    $prepare->bindValue(":".$key_array, $value_array);
                }
                $prepare->bindValue(":id", $sales_products_id);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in SalesProductsModel => ".$err;
                return false;
            }
        }

        protected function deleteById(int $sales_products_id)
        {
            $query = "DELETE FROM `".$this->table."` WHERE id = :id";
            try
            {
                $prepare = $this->database ->prepare($query);
                $prepare->bindParam(":id", $sales_products_id);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in SalesProductsModel => ".$err;
                return false;
            }
        }

        public function getAllSalesProductBySalesID(int $sales_id) : array | false
        {
            $query = "SELECT * FROM `".$this->table."` WHERE sales_id = :sales_id";
            try
            {
                $prepare = $this->database ->prepare($query);
                $prepare->bindParam(":sales_id", $sales_id);
                $prepare->execute();
                $result = $prepare->fetchAll($this->database::FETCH_ASSOC);
                
                if(count($result) <= 0)
                {
                    return false;
                }
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in SalesProductsModel => ".$err;
                return false;
            }
        }

        public function getOneSalesProductByID(int $sales_products_id) : array | false
        {
            $query = "SELECT * FROM `".$this->table."` WHERE id = :id";
            try
            {
                $prepare = $this->database ->prepare($query);
                $prepare->bindParam(":id", $sales_products_id);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in SalesProductsModel => ".$err;
                return false;
            }
        }
    }