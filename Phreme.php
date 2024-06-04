<?php

    namespace Phreme;

    defined("PHREME") OR exit("Forbidden Access");

    class Phreme {
        private $prefixes = [];

        /**
         * Register a namespace with a base directory.
         *
         * @param string $prefix
         * @param string $base_dir
         * @param bool $prepend
         * @return void
         */
        public function registerNamespace(string $prefix, string $base_dir, bool $prepend = false): void {
            $prefix = trim($prefix, "\\") . "\\";
            $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            if (!isset($this->prefixes[$prefix])) {
                $this->prefixes[$prefix] = [];
            }

            if ($prepend) {
                array_unshift($this->prefixes[$prefix], $base_dir);
            } else {
                array_push($this->prefixes[$prefix], $base_dir);
            }
        }

        /**
         * Attempt to load a class.
         *
         * @param string $class
         * @return bool
         */
        public function loadClass(string $class): bool {
            $prefix = $class;

            while (false !== $pos = strrpos($prefix, '\\')) {
                $prefix = substr($class, 0, $pos + 1);
                $relative_class = substr($class, $pos + 1);
                $mapped_file = $this->loadMappedFile($prefix, $relative_class);

                if ($mapped_file) {
                    return true;
                }

                $prefix = rtrim($prefix, '\\');
            }

            return false;
        }

        /**
         * Load a mapped file for a namespace prefix and relative class.
         *
         * @param string $prefix
         * @param string $relative_class
         * @return bool
         */
        protected function loadMappedFile(string $prefix, string $relative_class): bool {
            if (!isset($this->prefixes[$prefix])) {
                return false;
            }

            foreach ($this->prefixes[$prefix] as $base_dir) {
                $file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';

                if ($this->requireFile($file)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * If a file exists, require it from the filesystem.
         *
         * @param string $file
         * @return bool
         */
        protected function requireFile(string $file): bool {
            if (file_exists($file)) {
                require $file;
                return true;
            }

            return false;
        }

        /**
         * Register the autoload function and namespaces.
         *
         * @return void
         */
        public function registerClass(): void {
            spl_autoload_register([$this, "loadClass"]);

            // Ensure DIR is defined and points to the root of your project.
            defined('DIR') OR define('DIR', __DIR__);

            $this->registerNamespace("Phreme\\Dependencies", DIR . "/Dependencies/");
            $this->registerNamespace("Phreme\\Systems\\Database", DIR . "/Systems/Database/");
            $this->registerNamespace("Phreme\\Systems", DIR . "/Systems/");
            $this->registerNamespace("Phreme\\App\\Routes", DIR . "/Apps/Routes/");
            $this->registerNamespace("Phreme\\App\\Library", DIR . "/Apps/Libraries/");
            $this->registerNamespace("Phreme\\App\\Model", DIR . "/Apps/Models/");
            $this->registerNamespace("Phreme\\App\\Controller", DIR . "/Apps/Controllers/");
        }

        /**
         * Run the application.
         *
         * @return void
         */
        public function run(): void {
            $this->registerClass();
            
            (new \Phreme\Dependencies\Hook())->set();
            (new \Phreme\App\Routes\Routes())->run();
        }
    }