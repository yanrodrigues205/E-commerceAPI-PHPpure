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

        public function validateToken(string $token)
        {
            $token = str_replace([" ", "Bearer"], "", $token);
            $response = "";

            if($token)
            {
                if(!empty($token))
                {
                    $query = "SELECT id, value, expiry, user_id, created_at, updated_at FROM " . $this->table . " WHERE value = :token ";
                    $result = $this->database->getDB()->prepare($query);
                    $result->bindParam(':token', $token);
                    $result->execute();

                    $results = $result->fetchAll(PDO::FETCH_ASSOC);

                    if(count($results) !== 1)
                    {
                        //NAO AUTORIZADO
                        header("HTTP/1.1 401 Unauthorized");
                        $response = [
                            "message" => "NAO AUTORIZADO!",
                            "status" => 401
                        ];
                        echo json_encode($response);
                        exit();
                    }
                    
                }
                else
                {
                    header("HTTP/1.1 401 Unauthorized");
                    $response = [
                        "message" => "You sent something invalid or left the access token empty!",
                        "status" => 401
                    ];
                    echo json_encode($response);
                    exit();
                }

            }

        }
    }
?>