<?php
    namespace repositories;
    use database\MySql;
use ErrorException;
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
    }