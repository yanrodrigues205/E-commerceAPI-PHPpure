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
            // $token = str_replace([" ", "Bearer"], "", $token);

            if(!empty($token))
            {
                $query = "SELECT id, value, expiry, user_id, created_at, updated_at FROM " . $this->table . " WHERE value = :token ";
                $result = $this->database->getDB()->prepare($query);
                $result->bindParam(':token', $token);
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
?>