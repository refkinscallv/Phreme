<?php

    namespace Phreme\Systems\Database;

    defined("PHREME") OR exit("Forbidden Access");

    class Connection {

        private $host;
        private $user;
        private $pass;
        private $name;

        public function __construct(){
            $this->host = $_SERVER["DB_HOST"];
            $this->user = $_SERVER["DB_USER"];
            $this->pass = $_SERVER["DB_PASS"];
            $this->name = $_SERVER["DB_NAME"];
        }
        
        /**
         * connection()
         *
         * @return ?
         */
        public function connection(){
            return new \mysqli($this->host, $this->user, $this->pass, $this->name);
        }

    }