<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Access");

    class Input {
        
        /**
         * sanitize()
         *
         * @param  mixed $value
         * @return mixed
         */
        private function sanitize(mixed $value): mixed {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        
        /**
         * extract_to_array()
         *
         * @param  array $data
         * @param  mixed $index
         * @return mixed
         */
        private function extract_to_array(array $data, mixed $index = null): mixed {
            $result = [];

            $index = $index ?? false;

            if ($index !== false) {
                if (isset($data[$index])) {
                    return [$index => $this->sanitize($data[$index])];
                }
            } else {
                foreach ($data as $key => $value) {
                    $result[$key] = $this->sanitize($value);
                }
            }

            return $result;
        }
        
        /**
         * post()
         *
         * @param  mixed $index
         * @return mixed
         */
        public function post(mixed $index = null): mixed {
            return $this->extract_to_array($_POST, $index);
        }
        
        /**
         * get()
         *
         * @param  mixed $index
         * @return mixed
         */
        public function get(mixed $index = null): mixed {
            return $this->extract_to_array($_GET, $index);
        }
        
        /**
         * request()
         *
         * @param  mixed $index
         * @return mixed
         */
        public function request(mixed $index = null): mixed {
            return $this->extract_to_array($_REQUEST, $index);
        }
        
        /**
         * server()
         *
         * @param  mixed $index
         * @return mixed
         */
        public function server(mixed $index = null): mixed {
            return $this->extract_to_array($_SERVER, $index);
        }

    }