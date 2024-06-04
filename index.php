<?php

    /**
     *  ____  _                             
     * |  _ \| |__  _ __ ___ _ __ ___   ___ 
     * | |_) | '_ \| '__/ _ \ '_ ` _ \ / _ \
     * |  __/| | | | | |  __/ | | | | |  __/
     * |_|   |_| |_|_|  \___|_| |_| |_|\___|
     * 
     * Phreme - A Simple PHP Framework with MVC Architecture 
     */

    use Phreme\Phreme;

    /**
     * global variable
     */
    define("PHREME", true);
    define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
    define("DIR", __DIR__);

    /**
     * composer autoload
     */
    require "vendor/autoload.php";

    /**
     * phreme loader
     */
    require "Phreme.php";

    /**
     * running phreme
     */
    (new Phreme())->run();