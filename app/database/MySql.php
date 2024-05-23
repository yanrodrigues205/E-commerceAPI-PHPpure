<?php 
    namespace database;

    use PDO;
    use PDOException;

    class MySql
    {
        private static $instance = null;
        private $database;
        private string $db_name = DATABASE_NAME;
        private string $db_host = DATABASE_HOST;
        private string $db_user = DATABASE_USER;
        private string $db_pass = DATABASE_PASS;


        private function __construct()
        {
            try
            {
                $this->database = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);
                
            }
            catch(PDOException $e)
            {
                echo "Database connection error => " . $e->getMessage();
            }
        }


        public static function getInstance() : self
        {
            if(!self::$instance)
                self::$instance = new self();

            return self::$instance;
        }

        public function getConnector() : PDO
        {
            return $this->database;
        }


        private function __clone(): void
        {
            // method created to prevent php clone action
        }

        private function __wakeup() : void
        {
            // method created to prevent php decentralization
        }
    }