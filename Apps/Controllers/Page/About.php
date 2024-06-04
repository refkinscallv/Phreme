<?php

    namespace Phreme\App\Controller;

    defined("PHREME") OR exit("Forbidden Access");

    class About extends \Phreme\Systems\Controller {

        public function __construct(){
            parent::__construct();
        }
        
        public function index($param1 = false, $param2 = false){
            echo "About@index <br />";
            echo "Paramater 1 : " . $param1 . "<br />";
            echo "Paramater 2 : " . $param2 . "<br />";
        }

    }