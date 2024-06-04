<?php

    namespace Phreme\App\Controller;

    defined("PHREME") OR exit("Forbidden Access");

    class Home extends \Phreme\Systems\Controller {

        public function __construct(){
            parent::__construct();
        }
        
        public function index(){
            $this->load->view("home", [
                "title" => $_SERVER["APP_NAME"],
                "appName" => $_SERVER["APP_NAME"],
                "message" => "Phreme - is a PHP framework offers a comprehensive set of features to streamline web development",
            ]);
        }

    }