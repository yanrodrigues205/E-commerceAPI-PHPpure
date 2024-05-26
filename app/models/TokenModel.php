<?php
    namespace models;
    use database\MySql;
    use PDO;
    use Exception;
    use services\UUIDService;

    class TokenModel
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
             $this->table = "tokens";
        }


        public function verify(string $token) : array | false
        {
            if(!empty($token))
            {
                $data_atual = date("Y-m-d H:i:s");
                $query = "SELECT id, value, expiry, user_id, created_at, updated_at FROM " . $this->table . " WHERE value = :token AND created_at <= :data_atual AND expiry >= :data_atual LIMIT 1";
                $result = $this->database->prepare($query);
                $result->bindParam(':token', $token);
                $result->bindParam(':data_atual', $data_atual, PDO::PARAM_STR);
                $result->execute();

                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                return false;
            }
        }


        public function insert(int $user_id) : string | false
        {
            $query = "INSERT INTO `" .$this->table . "`
                ( value, user_id ) VALUES ( :value, :user_id )";

            $uuid = UUIDService::create();
            try
            {
                $result = $this->database->prepare($query);
                $result->bindParam(":value", $uuid);
                $result->bindParam(":user_id", $user_id);
                $results = $result->execute();
                if($results)
                {
                    return $uuid;
                }
                else
                {
                    return false;
                }
            }
            catch(Exception $err)
            {
                echo "New exeption in UserRepository, Exception => ".$err;
                return false;
            }
        }
    }