<?php
    class Database
    {
        private $servername = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'todos';
        public $_db_connect = "";

        function __construct()
        {
            $this->_db_connect = mysqli_connect($this -> servername, $this -> username, $this -> password, $this -> dbname);
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

    }
?>