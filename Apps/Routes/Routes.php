<?php

    namespace Phreme\App\Routes;

    defined("PHREME") OR exit("Forbidden Access");

    class Routes {

        public function __construct(){
            $this->route = new  \Phreme\Systems\Route();
        }
        
        /**
         * Define the routes.
         * 
         * @return void
         */
        public function run(): void {
            /**
             * Format to set route for controller
             * 
             * $this->route->set(#PATH, #CONTROLLER, #PARAM);
             * 
             * (String) #PATH : To indicate a controller will be used at a specific path in URL
             * (String) #CONTROLLER : A controller class to be used includes the directory where the controller file is located.
             * (Boolean) #PARAM : For permission to use parameters as values ​​in the controller
             */

            $this->route->setDefault("Home@index", true);

            $this->route->run();
        }
    }
