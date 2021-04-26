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

    // -- Site settings --------------------------------------------------------
        $site_data = array(
            "site_name"  => "Broadstone",
            "site_subDomain" => 'broadstone',
            "site_root"  => "/redesign-flock-book",
            "base_email" => "pat@moonspace.co.uk"
        );
	    date_default_timezone_set('Europe/London');
    // -------------------------------------------------------------------------

	session_start();

?>
