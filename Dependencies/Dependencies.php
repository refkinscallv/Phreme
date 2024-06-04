<?php

    namespace Phreme\Dependencies;

    defined("PHREME") OR exit("Forbidden Access");

    use CG\FVSS\Fvss;

    use Dotenv\Dotenv;

    use Whoops\Run;
    use Whoops\Handler\PrettyPageHandler;

    class Dependencies {
                
        /**
         * dotEnv()
         * @source vlucas/phpdotenv (Installed from : composer require vlucass/phpdotenv)
         *
         * @return void
         */
        public static function dotEnv(){
            Dotenv::createImmutable(DIR)->load();
        }

        /**
         * errorTrace()
         * @source filp/whoops (Installed from : composer require filp/whoops)
         *
         * @return void
         */
        public static function errorTrace(){
            if(isset($_SERVER["ENVIRONTMENT"]) && $_SERVER["ENVIRONTMENT"] === "development"){
                error_reporting(-1);
                
                $whoops = new Run;
                $prettyPageHandler = new PrettyPageHandler();

                $blacklistItem = [
                    "PHP_AUTH_PW",
                    "APP_NAME",
                    "BASE_URL",
                    "ENVIRONTMENT",
                    "DB_HOST",
                    "DB_USER",
                    "DB_PASS",
                    "DB_NAME",
                    "CRYPT_PRIVATE_KEY",
                    "CRYPT_FILE",
                    "CRYPT_LIMIT",
                    "COOKIE_NAME",
                    "COOKIE_EXPIRE",
                    "COOKIE_FILE"
                ];

                foreach($blacklistItem as $item){
                    $prettyPageHandler->hideSuperglobalKey("_SERVER", $item);
                    if($item !== "PHP_AUTH_PW"){
                       $prettyPageHandler->hideSuperglobalKey("_ENV", $item);
                    }
                }

                $whoops->pushHandler($prettyPageHandler);
                $whoops->register();
            } else {
                error_reporting(0);
            }
        }

        /**
         * formValidate()
         * @source refkinscallv/fvss (Installed from : composer require refkinscallv/fvss)
         *
         * @return Fvss
         */
        public static function formValidate(){
            return new Fvss();
        }

    }