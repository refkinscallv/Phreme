<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Access");

    class Cookie extends \Phreme\Systems\Security {

        private $CookieName;
        private $CookieExpire;
        private $CookieFile;

        public function __construct(){
            $this->CookieName = $_SERVER["COOKIE_NAME"];
            $this->CookieExpire = $_SERVER["COOKIE_EXPIRE"];
            $this->CookieFile = $_SERVER["COOKIE_FILE"];
        }
        
        /**
         * gets()
         *
         * @return array
         */
        public function gets(): array {
            if(isset($_COOKIE[$this->CookieName])){
                return $this->decrypt($_COOKIE[$this->CookieName], "array", $this->CookieFile);
            } else {
                return [];
            }
        }
        
        /**
         * get()
         *
         * @param  string $name
         * @return mixed
         */
        public function get(string $name = null): mixed {
            if($name){
                $get_cookie = $this->gets();

                if(!empty($get_cookie) && isset($get_cookie[$name])){
                    return $get_cookie[$name];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        
        /**
         * set()
         *
         * @param  mixed $data
         * @param  mixed $value
         * @return void
         */
        public function set(mixed $data, mixed $value = null): void {
            $get_cookie = $this->gets();

            if(is_array($data)){
                foreach($data as $index => $val){
                    $get_cookie[$index] = $val;
                }
            } else {
                $get_cookie[$data] = $value;
            }
            
            $set_cookie = $this->encrypt($get_cookie, "array", $this->CookieFile);
            setcookie($this->CookieName, $set_cookie, time() + ($this->CookieExpire * 60 * 60), "/");
        }
        
        /**
         * unset
         *
         * @param  string $name
         * @return void
         */
        public function unset(string $name): void {
            $get_cookie = $this->gets();

            if(is_array($name)){
                foreach($name as $index){
                    unset($get_cookie[$index]);
                }
            } else {
                unset($get_cookie[$name]);
            }

            $set_cookie = $this->encrypt($get_cookie, "array", $this->CookieFile);
            setcookie($this->CookieName, $set_cookie, time() + ($this->CookieExpire * 60 * 60), "/");
        }

    }