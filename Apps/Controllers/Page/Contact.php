<?php

    namespace Phreme\App\Controller;

    defined("PHREME") OR exit("Forbidden Access");

    class Contact extends \Phreme\Systems\Controller {

        public function __construct(){
            parent::__construct();
        }
        
        public function index(){
            echo "Contact@index";
        }

    }