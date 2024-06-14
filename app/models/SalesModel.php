<?php
    namespace models;
    use PDO;
    use Exception;
    use database\MySql;
    class SalesModel
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
             $this->table = "sales";
        }

        public function getOneSalesByID(int $id)
        {
            $query = "SELECT * FROM `".$this->table."` WHERE id = :id ";
            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();
                $all = $prepare->fetchAll($this->database::FETCH_ASSOC);

                if(count($all) == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Model, Exception => ".$err;
                return false;
            }
        }

        protected function initSales(int $user_id) : int | false
        {
            $query = "INSERT INTO `" .$this->table . "`
            ( user_id ) VALUES ( :user_id)";
            try
            {
                $result = $this->database->prepare($query);
                $result->bindParam(":user_id", $user_id);
                $results = $result->execute();

                // Obtém o ID do último registro inserido
                $lastInsertId = $this->database->lastInsertId();

                return $lastInsertId ? (int)$lastInsertId : false;
            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Model, Exception => ".$err;
                return false;
            }
        }


        protected function endSales(int $sales_id, string $payment) : bool
        {
            $select_sales_products = "SELECT 
                                        products.name, 
                                        products.description, 
                                        products.value, 
                                        sales_products.amount, 
                                        (sales_products.amount * products.value) AS item_value 
                                        FROM sales_products 
                                        INNER JOIN products 
                                        ON sales_products.product_id = products.id 
                                        WHERE sales_products.sales_id = :sales_id";

            $query = "UPDATE `".$this->table."` 
            SET total_price = :total_price, payment = :payment 
            WHERE id = :id";

            try
            {
                $prepare_select = $this->database->prepare($select_sales_products);
                $prepare_select->bindParam(":sales_id", $sales_id);

                $prepare_select->execute();
                $all_select = $prepare_select->fetchAll($this->database::FETCH_ASSOC);

                if(count($all_select) > 0)
                {
                    $total = 0;
                    for($i = 0; $i < count($all_select); $i++)
                    {
                        $total += $all_select[$i]["item_value"];
                    }
               
                    $prepare = $this->database->prepare($query);
                    $prepare->bindParam(":id", $sales_id);
                    $prepare->bindParam(":total_price", $total);
                    $prepare->bindParam(":payment", $payment);
                    $result = $prepare->execute();
                    return $result;

                }
                else
                {
                    return false;
                }
            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Model, Exception => ".$err;
                return false;
            }
        }
    }