<?php

require_once("vendor/autoload.php");
require_once("app/DB/config.php");
require_once("app/DB/result.php");

    class AuthDB{
        private $config;
        private $result;

        public function __construct(DBConfig $config){
            $this->config = $config;
        }

        public function AuthDBLogin(string $login, string $password){
            $this->config->DBConnect();

            $sql = "SELECT * FROM auth_users WHERE username = '$login' AND password = '$password'";
            $this->result = new DBResult($this->config->DBQuery($sql));

            $this->config->DBClose();

            return $this->result->DBResultFetch();
        }

        public function GetUserByLogin(string $login){
            $this->config->DBConnect();

            $sql = "SELECT * FROM auth_users WHERE username = '$login'";
            $this->result = new DBResult($this->config->DBQuery($sql));

            $this->config->DBClose();

            return $this->result->DBResultFetch();
        }

        public function RegisterUser(string $login, string $password){
            $this->config->DBConnect();

            $sql = "INSERT INTO auth_users (username, password) VALUES ('$login', '$password')";
            $this->result = new DBResult($this->config->DBQuery($sql));

            $this->config->DBClose();

            return $this->result;
        }

        public function DeleteUser(string $login){
            $this->config->DBConnect();

            $sql = "DELETE FROM auth_users WHERE username = '$login'";
            $this->result = new DBResult($this->config->DBQuery($sql));

            $this->config->DBClose();

            return $this->result;
        }
    }

?>