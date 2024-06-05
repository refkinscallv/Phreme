<?php

    namespace Phreme\Systems;
    
    defined("PHREME") OR exit("Forbidden Access");

    class Route {

        private $routesStorage;
        private $defRoutesStorage;

        public function __construct(){
            $this->routesStorage = [];
            $this->defRoutesStorage = [];
        }
        
        /**
         * setDefault()
         *
         * @param  string $controller
         * @param  bool $param
         * @return void
         */
        public function setDefault(string $controller = null, bool $param = false): void {
            if($controller){
                $this->defRoutesStorage[] = [
                    "controller" => $controller,
                    "param" => $param
                ];
            } else {
                $this->notFound();
            }
        }
        
        /**
         * set()
         *
         * @param  string $path
         * @param  string $controller
         * @param  bool $param
         * @return void
         */
        public function set(string $path, string $controller, bool $param): void {
            if($controller){
                $this->routesStorage[] = [
                    "path" => rtrim($path, "/"),
                    "controller" => $controller,
                    "param" => $param
                ];
            } else {
                $this->notFound();
            }
        }
        
        /**
         * defaultController()
         *
         * @return void
         */
        public function defaultController(): void {
            if(count($this->defRoutesStorage) > 0){
                $thisController = $this->defRoutesStorage[0]["controller"];
                $thisParam = $this->defRoutesStorage[0]["param"];

                $currentUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
                $currentUriClean = rtrim($currentUri, "/");

                $setParam = ($thisParam ? array_values(array_filter(explode("/", $currentUriClean))) : []);

                $setRawClass = explode("@", $thisController);
                $setFileClass = ROOT . "/Apps/Controllers/" . str_replace("\\", "/", $setRawClass[0]) . ".php";

                if(file_exists($setFileClass)){
                    require $setFileClass;

                    $setClassName = $setRawClass[0];
                    $explodeClassName = explode("/", $setClassName);
                    $setClassName = end($explodeClassName);

                    $classWithNamespace = "Phreme\App\Controller\\" . $setClassName;

                    $checkingClassAndMethod = $this->reflectionMethod($classWithNamespace, $setRawClass[1]);

                    if (($checkingClassAndMethod >= 0 && count($setParam) == 0) || (count($setParam) <= $checkingClassAndMethod)) {
                        $declaredClass = new $classWithNamespace();

                        if(class_exists($declaredClass)){
                            if(method_exists($declaredClass, $setRawClass[1])){
                                call_user_func_array([$declaredClass, $setRawClass[1]], $setParam);
                            } else {
                                $this->notFound();
                            }
                        } else {
                            $this->notFound();
                        }
                    } else {
                        $this->notFound();
                    }
                } else {
                    $this->notFound();
                }
            }
        }
        
        /**
         * run()
         *
         * @return void
         */
        public function run(): void {
            $routeMatched = false;

            foreach($this->routesStorage as $index => $val){
                $thisPath = $val["path"];
                $thisController = $val["controller"];
                $thisParam = $val["param"];

                $currentUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
                $currentUriClean = rtrim(str_replace($thisPath, "", $currentUri), "/");

                if(strpos($currentUri, $thisPath) === 0){
                    $routeMatched = true;

                    $setParam = ($thisParam ? array_values(array_filter(explode("/", $currentUriClean))) : []);

                    $setRawClass = explode("@", $thisController);
                    $setFileClass = ROOT . "/Apps/Controllers/" . str_replace("\\", "/", $setRawClass[0]) . ".php";

                    if(file_exists($setFileClass)){
                        require $setFileClass;

                        $setClassName = $setRawClass[0];
                        $explodeClassName = explode("/", $setClassName);
                        $setClassName = end($explodeClassName);

                        $classWithNamespace = "Phreme\App\Controller\\" . $setClassName;

                        $checkingClassAndMethod = $this->reflectionMethod($classWithNamespace, $setRawClass[1]);

                        if (($checkingClassAndMethod >= 0 && count($setParam) == 0) || (count($setParam) <= $checkingClassAndMethod)) {
                            $declaredClass = new $classWithNamespace();

                            if(class_exists($declaredClass)){
                                if(method_exists($declaredClass, $setRawClass[1])){
                                    call_user_func_array([$declaredClass, $setRawClass[1]], $setParam);
                                } else {
                                    $this->notFound();
                                }
                            } else {
                                $this->notFound();
                            }
                        } else {
                            $this->notFound();
                        }
                    } else {
                        $this->notFound();
                    }

                    return;
                }
            }

            if(!$routeMatched){
                if(count($this->defRoutesStorage) > 0){
                    $this->defaultController();
                    return;
                } else {
                    $this->notFound();
                }
            }
        }
        
        /**
         * checkParam()
         *
         * @param  string $class
         * @param  string $method
         * @return int
         */
        public function reflectionMethod(string $class, string $method): int {
            $reflectionClass = new \ReflectionClass($class);
            $reflectionMethod = $reflectionClass->getMethod($method);

            $params = $reflectionMethod->getParameters();
            $paramsCount = count($params);

            return $paramsCount;
        }
        
        /**
         * notFound()
         *
         * @return void
         */
        public function notFound(): void {
            http_response_code(404);
            include ROOT . "/Apps/Views/error/page404.php";
            die();
        }

    }