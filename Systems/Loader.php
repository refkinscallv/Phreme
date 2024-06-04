<?php

    namespace Phreme\Systems;

    defined("PHREME") OR exit("Forbidden Acces");

    class Loader {
                
        /**
         * view()
         *
         * @param  string $view
         * @param  array $data
         * @return void
         */
        public function view(string $view, array $data = []): void {
            $output = array_merge([
                "self_load" => $this
            ], $data);

            extract($output);

            include ROOT . "/Apps/Views/" . $view . ".php";
        }
        
        /**
         * model()
         *
         * @param  string $models
         * @param  string $alias
         * @return mixed
         */
        public function model($models, $alias = null) {
            if (is_array($models)) {
                $modelInstances = [];
                foreach ($models as $model => $modelAlias) {
                    if (is_int($model)) {
                        $model = $modelAlias;
                        $modelAlias = null;
                    }
                    $modelInstances[$modelAlias ?? $this->getModelClassName($model)] = $this->loadModel($model);
                }
                return (object) $modelInstances;
            } else {
                return $this->loadModel($models, $alias);
            }
        }
        
        /**
         * library
         *
         * @param  string $libraries
         * @param  string $alias
         * @return mixed
         */
        public function library($libraries, $alias = null) {
            if (is_array($libraries)) {
                $libraryInstances = [];
                foreach ($libraries as $library => $libraryAlias) {
                    if (is_int($library)) {
                        $library = $libraryAlias;
                        $libraryAlias = null;
                    }
                    $libraryInstances[$libraryAlias ?? $this->getLibraryClassName($library)] = $this->loadLibrary($library);
                }
                return (object) $libraryInstances;
            } else {
                return $this->loadLibrary($libraries, $alias);
            }
        }
        
        /**
         * loadModel()
         *
         * @param  mixed $model
         * @param  mixed $alias
         * @return mixed
         */
        private function loadModel($model, $alias = null) {
            $filePathInfo = pathinfo($model);
            $directory = isset($filePathInfo['dirname']) && $filePathInfo['dirname'] !== '.' ? $filePathInfo['dirname'] . '/' : '';
            $fileName = $filePathInfo['basename'];
            $fullPath = ROOT . "/Apps/Models/" . $directory . $fileName . ".php";

            if (!file_exists($fullPath)) {
                throw new \Exception("Model file not found: " . $fullPath);
            }

            require_once $fullPath;

            $modelName = '\\Phreme\\App\\Model\\' . $filePathInfo['filename'];
            $modelName = trim($modelName, '\\');

            if (!class_exists($modelName)) {
                throw new \Exception("Model class not found: " . $modelName);
            }

            return new $modelName();
        }
        
        /**
         * getModelClassName()
         *
         * @param  mixed $model
         * @return mixed
         */
        private function getModelClassName($model) {
            $filePathInfo = pathinfo($model);
            return $filePathInfo['filename'];
        }
        
        /**
         * loadLibrary()
         *
         * @param  mixed $library
         * @param  mixed $alias
         * @return mixed
         */
        private function loadLibrary($library, $alias = null) {
            $filePathInfo = pathinfo($library);
            $directory = isset($filePathInfo['dirname']) && $filePathInfo['dirname'] !== '.' ? $filePathInfo['dirname'] . '/' : '';
            $fileName = $filePathInfo['basename'];
            $fullPath = ROOT . "/Apps/Libraries/" . $directory . $fileName . ".php";

            if (!file_exists($fullPath)) {
                throw new \Exception("Library file not found: " . $fullPath);
            }

            require_once $fullPath;

            $libraryName = '\\Phreme\\App\\Library\\' . $filePathInfo['filename'];
            $libraryName = trim($libraryName, '\\');

            if (!class_exists($libraryName)) {
                throw new \Exception("Library class not found: " . $libraryName);
            }

            return new $libraryName();
        }
        
        /**
         * getLibraryClassName()
         *
         * @param  mixed $library
         * @return mixed
         */
        private function getLibraryClassName($library) {
            $filePathInfo = pathinfo($library);
            return $filePathInfo['filename'];
        }

    }