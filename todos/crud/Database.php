<?php

    class Database
    {
        private $servername = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'todos';
        public $_db_connect;

        function __construct()
        {
            $this->_db_connect = mysqli_connect($this -> servername, $this -> username, $this -> password, $this -> dbname);
        }

        function getDBConnection()
        {
            return $this->_db_connect;
        }

        function getUserPassword($email)
        {
            $select = "SELECT password FROM registration WHERE email='".$email."'";
            $encryptedPassword = mysqli_query($this->_db_connect, $select); 
            $row = mysqli_fetch_row($encryptedPassword);
            return $row[0];
        }

        function getUserName($email)
        {
            $select = "SELECT name FROM registration WHERE email='".$email."'";
            $name = mysqli_query($this->_db_connect, $select); 
            $row = mysqli_fetch_row($name);
            return $row[0];
        }

        function insertUserInfo($insertUser)
        {
            $name = $insertUser['name'];
            $email = $insertUser['email'];
            $encryptedPassword = $insertUser['encryptedPassword'];

            $insertQuery = "INSERT INTO `registration` (`id`, `name`, `email`, `password`) VALUES (NULL, '".$name."','".$email."','".$encryptedPassword."')";

            mysqli_query($this->_db_connect, $insertQuery);
            $insertAffect = mysqli_affected_rows($this->_db_connect);
            if($insertAffect == 1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        function insertNewTodo($insertTodo)
        {
            $newTodo = $insertTodo['newTodo'];
            $newTodoPriority = $insertTodo['newTodoPriority'];
            $email = $insertTodo['email'];

            $insertQuery = "INSERT INTO `todos` (`id`, `task`, `priority`, `email`) VALUES (NULL, '".$newTodo."','".$newTodoPriority."','".$email."')";

            mysqli_query($this->_db_connect, $insertQuery);
            $insertAffect = mysqli_affected_rows($this->_db_connect);
            if($insertAffect == 1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        function getToalNoOfRecords()
        {
            $qry = mysqli_query($this->_db_connect, "SELECT COUNT(*) AS totalcount FROM todos");
            $records = mysqli_fetch_assoc($qry);
            return $records['totalcount'];
        }

        function getFilteredNoOfRecords($searchString)
        {
            $qry = mysqli_query($this->_db_connect, "SELECT COUNT(*) AS filtercount FROM todos WHERE 1".$searchString);
            $records = mysqli_fetch_assoc($qry);
            return $records['filtercount'];
        }

    }
?>