<?php

    class Sheep extends Db{

        // -- Get all sheep ---------------------------------------------------
            public function getAllSheep(){
                $this -> connect();

                    $sql = self::$conn -> prepare("SELECT * FROM livestock ORDER BY livestock_name");
                    $sql->execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p><strong>$row[livestock_name]</strong> $row[uk_tag_no]</p>";
                    }

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count sheep ------------------------------------------------------
            public function countSheep($varient){
                switch($varient){
                    case 'all':
                        $query = "SELECT COUNT(id) AS sheepCount FROM livestock WHERE deleted != 1";
                    break;
                    case 'alive':
                        $query = "SELECT COUNT(id) AS sheepCount FROM livestock WHERE deleted != 1 AND date_of_death IS null";
                    break;
                    case 'dead':
                        $query = "SELECT COUNT(id) AS sheepCount FROM livestock WHERE deleted != 1 AND date_of_death IS NOT null";
                    break;
                    case 'female':
                        $query = "SELECT COUNT(id) AS sheepCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 2";
                    break;
                    case 'male':
                        $query = "SELECT COUNT(id) AS sheepCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 1";
                    break;
                }
                $this -> connect();

                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['sheepCount'];

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

    }

?>
