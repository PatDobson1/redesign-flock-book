<?php

    class Db{
        
        public static $conn = null;
        
        // -- Connection details -----------------------------------------------
            private $db_servername = "localhost";
            private $db_username = "fb_redesign";
            private $db_password = "Bjb29v&6__7][hGuye788";
            private $db_dbName = "fb_redesign";
        // ---------------------------------------------------------------------
            
        // -- Set up database connection ---------------------------------------
            protected function connect(){
                $pdo = new PDO("mysql:host=$this->db_servername;dbname=$this->db_dbName", $this->db_username, $this->db_password);
                $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$conn = $pdo;
            }
        // ---------------------------------------------------------------------

        // -- Disconnect from database -----------------------------------------
            protected function disconnect(){
                self::$conn = null;
            }
        // ---------------------------------------------------------------------

    }

?>

