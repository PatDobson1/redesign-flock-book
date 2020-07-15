<?php

    // -- Error reporting ------------------------------------------------------
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
    // -------------------------------------------------------------------------
	
    // -- Load classes ---------------------------------------------------------
        function class_autoloader($class){
            include 'includes/classes/' . $class . '.class.php';
        }
        spl_autoload_register('class_autoloader');
    // -------------------------------------------------------------------------

	date_default_timezone_set('Europe/London');

	session_start();

?>