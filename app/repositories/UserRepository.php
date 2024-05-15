<?php
    namespace repositories;
    use database\MySql;
    use Exception;

    class UserRepository
    {
        private string $table = "users";
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

         public function insertUser(array $data) : mixed
         {
            $query = "INSERT INTO `".$this->table."`
                    (
                        name,
                        email,
                        password
                    )
                    VALUES
                    (
                        :name,
                        :email,
                        :password
                    )";

            try
            {
                $db = $this->database->getDB();
                $prepare = $db->prepare($query);
                $prepare->bindParam(":name", $data["name"]);
                $prepare->bindParam(":email", $data["email"]);
                $prepare->bindParam(":password", $data["password"]);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New exception in UserRepository, Exception => ".$err;
            }
         }

         
        public function existsEmail($email) : bool
        {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email";

            try
            {
                $db = $this->database->getDB();
                $prepare = $db->prepare($query);
                $prepare->bindParam(":email", $email);
                $prepare->execute();
                $all = $prepare->fetchAll($db::FETCH_ASSOC);    
                if(count($all) > 0)
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
                echo "Error verify email => ".$err;
                return false;
            }    
        }

        public function verifyUser(array $data)
        {
            $query = "SELECT 
                        id,
                        name,
                        email,
                        password,
                        created_at,
                        updated_at
                    FROM 
                        users
                    WHERE
                        email = :email AND
                        password = :password
                    LIMIT 1";
            try
            {
                $db = $this->database->getDB();
                $prepare = $db->prepare($query);
                $prepare->bindParam(":email", $data["email"]);
                $prepare->bindParam(":password", $data["password"]);

                $result = $prepare->execute();
                $all = $prepare->fetchAll($db::FETCH_OBJ);
   
                if(count($all) > 0)
                    return $all;
                else
                    return false;
                
            }
            catch(Exception $err)
            {
                echo "Error when verifying user credentials => ".$err;
                return false;
            }
        }
    }