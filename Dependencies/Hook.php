<?php

    namespace Phreme\Dependencies;

    defined("PHREME") OR exit("Forbidden Access");

    class Hook {
        
        /**
         * set()
         *
         * @return void
         */
        public function set(){
            /**
             * First create a function from the library that you have installed in the `Dependencies.php` file, then set it here to automatically use the library.
             */
            
            \Phreme\Dependencies\Dependencies::dotEnv();
            \Phreme\Dependencies\Dependencies::errorTrace();
        }

    }