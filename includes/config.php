<?php

    session_start();

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
            "site_root"  => "",
            "base_email" => "pat@moonspace.co.uk"
        );
	    date_default_timezone_set('Europe/London');
    // -------------------------------------------------------------------------

	// -- SMTP config ----------------------------------------------------------
		$smtp_host = "moonspace.co.uk";
		$smtp_username = "ptbSMTP@moonspace.co.uk";
		$smtp_password = "uMa53t^6_76GHgfD";
	// -------------------------------------------------------------------------

    // -- Login ----------------------------------------------------------------
        if( !isset($_SESSION['loggedIn']) ){
            $_SESSION['loggedIn'] = false;
        };
        if( isset($_GET['logout']) ){
			$_SESSION['loggedIn'] = false;
			$_SESSION['userId'] = null;
		};
        if( !$_SESSION['loggedIn'] ){
            if( isset($_POST['username']) ){
                $generic = new Generic();
                $generic -> attemptLogin($_POST);
                exit;
            }else{
                $layout = new Layout();
                $layout -> login($site_data);
                exit;
            }
        }
        if( isset($_SESSION['loggedIn']) && $_SESSION['changePassword'] ){
            if(isset($_POST['changePassword'])){
                $generic = new Generic();
                $generic -> changePasswordFirstLogin($_POST);
                exit;
            }else{
                $layout = new Layout();
                $layout -> firstVisit($site_data);
                exit;
            }
        }
    // -------------------------------------------------------------------------


?>
