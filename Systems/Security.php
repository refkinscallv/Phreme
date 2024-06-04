<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Access");

    class Security {

        protected $CryptPrivateKey;
        protected $CryptFile;
        protected $CryptLimit;

        public function __construct(){
            $this->CryptPrivateKey = $_SERVER["CRYPT_PRIVATE_KEY"];
            $this->CryptFile = $_SERVER["CRYPT_FILE"];
            $this->CryptLimit = $_SERVER["CRYPT_LIMIT"];
        }
        
        /**
         * encrypt()
         *
         * @param  mixed $data
         * @param  string $type
         * @param  string $file
         * @return mixed
         */
        public function encrypt(mixed $data = null, string $type = "string", string $file = null): mixed {
            if($data){
                if($type === "array"){
                    $data = @serialize($data);
                }

                $openSSL = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));
                $encrypt = openssl_encrypt($data, "AES-256-CBC", $this->CryptPrivateKey, 0, $openSSL);
                $base64 = base64_encode($encrypt ."::". $openSSL);
                $md5 = md5($base64);

                $result = $md5;
                $this->translate($base64 .":". $md5, "write", $file);
            } else {
                $result = false;
            }

            return $result;
        }
        
        /**
         * decrypt()
         *
         * @param  mixed $data
         * @param  string $type
         * @param  string $file
         * @return mixed
         */
        public function decrypt(mixed $data = null, string $type = "string", string $file = null): mixed {
            if($data){
                $data = $this->translate($data, "read", $file);

                list($encrypt, $openSSL) = explode("::", base64_decode($data), 2) + [null, null];
                $decrypt = openssl_decrypt($encrypt, "AES-256-CBC", $this->CryptPrivateKey, 0, $openSSL);

                if($type === "array"){
                    $result = @unserialize($decrypt);
                } else {
                    $result = $decrypt;
                }
            } else {
                $result = false;
            }

            return $result;
        }
        
        /**
         * translate()
         *
         * @param  mixed $data
         * @param  string $type
         * @param  string $file
         * @return mixed
         */
        private function translate(mixed $data, string $type, string $file): mixed {
            $CryptFile = fopen($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->CryptFile), "a");

            if($type === "write"){
                fwrite($CryptFile, $data . PHP_EOL);
                fclose($CryptFile);

                return $this->limit($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->CryptFile), $this->CryptLimit);
            } else if($type === "read"){
                return $this->read_file($_SERVER["DOCUMENT_ROOT"] . ($file ? $file : $this->CryptFile), $data);
            }

            return false;
        }
        
        /**
         * limit()
         *
         * @param  mixed $file
         * @param  int $limit
         * @return void
         */
        private function limit(mixed $file, int $limit): void {
            $file_contents = file($file);

            if(count($file_contents) > $limit){
                $file_contents = array_slice($file_contents, -$limit);
                file_put_contents($file, implode("", $file_contents));
            }
        }
        
        /**
         * read_file()
         *
         * @param  mixed $file
         * @param  mixed $data
         * @return mixed
         */
        private function read_file(mixed $file, mixed $data): mixed {
            $file = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach($file AS $text){
                $part = explode(":", $text);
                if(count($part) === 2 && $part[1] === $data){
                    return $part[0];
                }
            }

            return false;
        }

    }