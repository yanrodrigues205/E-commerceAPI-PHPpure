<?php
    namespace repositories;
    use database\MySql;
    use PDO;

    class TokenRepository
    {
        private $table = "tokens";

        private object $database;


        public function __construct()
        {
            $this->database = new MySql();
        }

        /**
         * @param string $token
         * @return array|false $results
         */

        public function validateToken(string $token)
        {
            if(!empty($token))
            {
                $data_atual = date("Y-m-d H:i:s");
                $query = "SELECT id, value, expiry, user_id, created_at, updated_at FROM " . $this->table . " WHERE value = :token AND created_at <= :data_atual AND expiry >= :data_atual LIMIT 1";
                $result = $this->database->getDB()->prepare($query);
                $result->bindParam(':token', $token);
                $result->bindParam(':data_atual', $data_atual, PDO::PARAM_STR);
                $result->execute();

                $results = $result->fetchAll(PDO::FETCH_ASSOC);                     
            }
            else
            {
                $results = false;
            }

            return $results;
        }
    }