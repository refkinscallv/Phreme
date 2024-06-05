<?php

    namespace Phreme\App\Controller;

    defined("PHREME") OR exit("Forbidden Access");

    class Home extends \Phreme\Systems\Controller {

        public function __construct(){
            parent::__construct();
        }
        
        public function index(){
            $this->load->view("home", [
                "official_url" => "https://phreme.callvgroup.net/",
                "app_name" => "Phreme",
                "version" => "1.0-dev"
            ]);
        }

    }