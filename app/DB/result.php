<?php

    class DBResult{
        private $result;

        public function __construct($result){
            $this->result = $result;
        }

        public static function FromConfigSql(DBConfig $config, string $sql){
            $config->DBConnect();

            $result = new DBResult( $config->DBQuery($sql));

            $config->DBClose();

            return $result;
        }

        public function DBResultFetch(){
            return mysqli_fetch_array($this->result);
        }
    }
    
?>