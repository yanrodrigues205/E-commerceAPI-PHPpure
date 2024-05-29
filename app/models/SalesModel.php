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
                echo "New exception in ProductRepository, Exception => ".$err;
            }
        }

        protected function insertSales(int $user_id)
        {
            $query = "INSERT INTO `" .$this->table . "`
            ( user_id ) VALUES ( :user_id)";
            try
            {
                $result = $this->database->prepare($query);
                $result->bindParam(":user_id", $user_id);
                $results = $result->execute();

                return $results;
            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Repository, Exception => ".$err;
                return false;
            }
        }
    }