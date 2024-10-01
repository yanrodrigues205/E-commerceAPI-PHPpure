<?php
    namespace models;
    use PDO;
    use Exception;
    use database\MySql;
use PDOException;

    class UsersModel
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
            $this->table = "users";
        }

        protected function insert(string $name, string $email, string $password) : bool
        {
            $password = md5($password);

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
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":name", $name);
                $prepare->bindParam(":email", $email);
                $prepare->bindParam(":password", $password);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New exception in UserRepository, Exception => ".$err;
                return false;
            }

        }

        protected function existsEmail(string $email) : bool
        {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email";

            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":email", $email);
                $prepare->execute();
                $all = $prepare->fetchAll($this->database::FETCH_ASSOC);
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


        public function getUserById(int $id)
        {
            $query = "SELECT * FROM `".$this->table."` WHERE id = :id ";
            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();
                $all = $prepare->fetchAll($this->database::FETCH_OBJ);

                if(count($all) > 0)
                {
                   return $all;
                }
                else
                {
                   return false;
                }

            }
            catch(Exception $err)
            {
                echo "New exception in ProductRepository, Exception => ".$err;
                return false;
            }
        }

        protected function verifyingCredentials(string $email, string $password)
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
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":email", $email);
                $prepare->bindParam(":password", md5($password));

                $result = $prepare->execute();
                $all = $prepare->fetchAll($this->database::FETCH_OBJ);
   
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


        protected function deleteById(int $id) : bool | int
        {
            $query = "DELETE FROM `".$this->table."` WHERE id = :id ";
            try
            {
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $result = $prepare->execute();

                if($result)
                    return true;
                else
                    return false;
            }
            catch(PDOException $err)
            {
               return $err->getCode();
            }
        }


        protected function getAllUsers(): array | bool
        {
            $query = "SELECT * FROM " . $this->table;

            try
            {
                $prepare = $this->database->query($query);
                $all = $prepare->fetchAll($this->database::FETCH_ASSOC);

                if(count($all) > 0)
                {
                    return $all;
                }
                else
                {
                    return false;
                }
            }
            catch(Exception $err)
            {
                echo "New Exception in UsersModel => ".$err;
                return false;
            }
        }

        protected function updateById(int | false $user_id, string | false $name, string | false $email, string | false $password) : bool
        {
            $data = [];

            if($name !== false && !empty($name))
            {
                $data["name"] = $name;
            }

            if($email !== false && !empty($email))
            {
                $data["email"] = $email;
            }

            if($password !== false && !empty($password))
            {
                $data["password"] = md5($password);
            }

            $query = "UPDATE ".$this->table." SET ";

            $i =0;
            foreach($data as $key_array => $value_array)
            { 
                if($i > 0)
                    $query .= " ,";
                $query .= $key_array." = :".$key_array;
                $i++;
            }

            $query .= " WHERE id = :id";

            try
            {
                $prepare = $this->database ->prepare($query);

                foreach($data as $key_array => $value_array)
                {
                    $prepare->bindValue(":".$key_array, $value_array);
                }
                $prepare->bindValue(":id", $user_id);
                $result = $prepare->execute();
                return $result;
            }
            catch(Exception $err)
            {
                echo "New Exeption Error in ProductsModel => ".$err;
                return false;
            }
        }

    }