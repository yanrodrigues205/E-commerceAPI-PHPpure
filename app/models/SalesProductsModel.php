<?php
    namespace models;
    use database\MySql;
    use PDO;
    use Exception;

    class SalesProductsModel
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
             $this->table = "sales_products";
        }

        public function insert(int $product_id, int $sales_id, int $amount)
        {
            new self();
            $query = "INSERT INTO `" .$this->table . "`
            ( product_id, sales_id, amount ) VALUES ( :product_id, :sales_id, :amount )";
            try
            {
                $result = $this->database->prepare($query);
                $result->bindParam(":product_id", $product_id);
                $result->bindParam(":sales_id", $sales_id);
                $result->bindParam(":amount", $amount);
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