<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Access");

    class Model {

        public $common;
        public $security;
        public $cookie;
        public $input;
        public $load;
        public $db;

        public function __construct(){
            $this->common   = new \Phreme\Systems\Common();
            $this->security = new \Phreme\Systems\Security();
            $this->cookie   = new \Phreme\Systems\Cookie();
            $this->input    = new \Phreme\Systems\Input();
            $this->load     = new \Phreme\Systems\Loader();
            $this->db       = new \Phreme\Systems\Database\Database();
        }

    }