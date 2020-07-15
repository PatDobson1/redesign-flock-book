<?php

    class Sheep extends Db{
        
        // -- Get all sheep ---------------------------------------------------
            public function getAllSheep(){
                $this -> connect();
                
                    $sql = self::$conn -> prepare("SELECT * FROM sheep ORDER BY sheep_name");
                    $sql->execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p>$row[sheep_name] $row[uk_tag_no]</p>";
//                         var_dump($row);
                    }
                
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------
        
    }

?>