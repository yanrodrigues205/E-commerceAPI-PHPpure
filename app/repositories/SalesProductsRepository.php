<?php
    namespace repositories;
    use database\MySql;
    use Exception;

    class SalesProductsRepository
    {
        private $table = "sales_products";
        private object $database;

        public function __construct()
        {
            $this->database = new MySql();
        }

        public function insertSalesProducts(array $data) : object | bool
        {
            $query = "INSERT INTO `" .$this->table . "`
            ( product_id, sales_id, amount ) VALUES ( :product_id, :sales_id, :amount )";
            try
            {
                $result = $this->database->getDB()->prepare($query);
                $result->bindParam(":product_id", $data['product_id']);
                $result->bindParam(":sales_id", $data['sales_id']);
                $result->bindParam(":amount", $data['amount']);
                $results = $result->execute();

                if($results)
                    return $results;
                else
                    return false;
            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Products Repository, Exception => ".$err;
                return false;
            }
        }
    }