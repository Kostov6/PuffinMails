<?php

    class Db
    {
        private $connection;
   
        public function __construct($dbName, $userPassword)
        {
            $dbhost = "localhost";
            $userName = "root"; 
            try{
                $this->connection = new PDO("mysql:host=".$dbhost.";dbname=".$dbName, $userName, $userPassword,
                    [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                $errorMsg = $e->getCode();
                if($errorMsg == 1045)
                {
                    echo "Trying to connect to DB with wrong password";
                } else if($errorMsg == 1049)
                {
                    echo "Could not establish connection. Maybe DB is not online? ";
                }
                else{
                    echo "Error in establishing connection to DB";
                }
                //1045 - wrong password 
                //1049 - could not connect
            }
        }
       
        public function getConnection()
        {
            return $this->connection;
        }

        public function insert($sql,$values)
        {
            $stmt=$this->connection->prepare($sql);
            $result=$stmt->execute($values);
            return $result;
        }

        public function select($sql,$values)
        {
            $stmt=$this->connection->prepare($sql);
            $result=$stmt->execute($values);
            return $stmt->fetchAll();
        }
    }


?>