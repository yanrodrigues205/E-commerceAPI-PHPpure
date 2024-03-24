<?php 
    namespace database;

    use InvalidArgumentException;
    use PDO;
    use PDOException;
    use Error;
    use utils\GlobalConstants;

    class MySql
    {
        private $database;
        private string $db_name = DATABASE_NAME;
        private string $db_host = DATABASE_HOST;
        private string $db_user = DATABASE_USER;
        private string $db_pass = DATABASE_PASS;


        public function __construct()
        {
            $this->database = $this->setConnection();
        }

        /**
         * @return PDO
         */

        private function setConnection()
        {
           try
           {
                $pdo = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ACTION error messages

                $pdo->query("SELECT 1");

                return $pdo;
            }
            catch (PDOException $e)
            {
                throw new Error("CONNECTION ERROR: " . $e->getMessage());
            }
        }

        /**
         * @param string $table
         * @param string $id
         * @return string
         */

        public function Delete(string $table, string $id) : mixed
        {
            $query = "DELETE FROM ".$table." WHERE id = :id";

            if(!empty($table) && !empty($id))
            {
                $this->database->beginTransaction();
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();

                if($prepare->rowCount()> 0)
                {
                    $this->database->commit();
                    return "Has been successfully deleted! ID => ".$id."; TABLE => ".$table.";";
                }

                $this->database->rollBack();
                throw new InvalidArgumentException("Error, Unable to perform delete operation!");
            }

            throw new InvalidArgumentException("Error, Fill in the '$table' and '$id' credentials to complete the operation!");
        }


        /**
         * @param string $table
         * @return array
         */
        public function getAll(string $table) : mixed
        {
            $query = "SELECT * FROM " . $table;
            $prepare = $this->database->query($query);

            $allRecords = $prepare->fetchAll($this->database::FETCH_ASSOC);

            if(is_array($allRecords) && count($allRecords) > 0)
            {
                return $allRecords;
            }

            throw new InvalidArgumentException("Error, Unable to search all records in the table!");
        }

        /**
         * @param string $table
         * @param string $id
         * @return array
         */

        public function getOne(string $table, string $id) : mixed
        {
            if(!empty($table) && !empty($id))
            {
                $query = "SELECT * FROM " . $table . " WHERE id = :id";
                $prepare = $this->database->prepare($query);
                $prepare->bindParam(":id", $id);
                $prepare->execute();
                $count = $prepare->rowCount();

                if($count === 1)
                {
                    return $prepare->fetch($this->database::FETCH_ASSOC);
                }

                throw new InvalidArgumentException("Error, It was not possible to select the item with id => ".$id.", in the table => ".$table.".");
            }
            throw new InvalidArgumentException("Error, Select the table and id to complete selecting a record!");
        }
    }