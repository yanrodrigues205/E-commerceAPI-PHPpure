<?php
    namespace repositories;
    use database\MySql;
    use Exception;

    class SalesRepository
    {
        private $table = "sales";
        private object $database;

        public function __construct()
        {
            $this->database = new MySql();
        }

        public function insertSales(array $data) : object | bool
        {
            $query = "INSERT INTO `" .$this->table . "`
            ( user_id ) VALUES ( :user_id)";
            try
            {
                $result = $this->database->getDB()->prepare($query);
                $result->bindParam(":user_id", $data['user_id']);
                $results = $result->execute();

                return $results;
            }
            catch(Exception $err)
            {
                echo "New exeption in Sales Repository, Exception => ".$err;
                return false;
            }
        }


        
        public function getOneByID(int $id) : mixed
        {
            $query = "SELECT * FROM `".$this->table."` WHERE id = :id ";
            try
            {
                $db = $this->database->getDB();
                $prepare = $db->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();
                $all = $prepare->fetchAll($db::FETCH_ASSOC);    
                
                return $all;

            }
            catch(Exception $err)
            {
                echo "New exception in ProductRepository, Exception => ".$err;
            }
        }
    }