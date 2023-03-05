<?php

    class DBConfig{
        private $host;
        private $username;
        private $password;
        private $bdname;

        public function __construct($host = "localhost", $username = "root", $password = "", $bdname = "stepit"){
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->bdname = $bdname;
        }

        public function DBConnect(){
            $conn = mysqli_connect($this->host, $this->username, $this->password, $this->bdname);

            if($conn == false) {
                return print("Произошла ошибка при выполнении запроса! ".mysqli_connect_error());
            }
            else {
                return $conn;
            }
        }

        public function DBQuery($sql){
            $result = mysqli_query($this->DBConnect(), $sql);

            if($result == false){
                return $this->DBPrintError();
            }
            else {
                return $result;
            }
        }

        public function DBError(){
            return mysqli_error($this->DBConnect());
        }

        public function DBPrintError(){
            return print("Произошла ошибка при выполнении запроса " . $this->DBError());
        }

        public function DBClose(){
            mysqli_close($this->DBConnect());
        }
    }

?>