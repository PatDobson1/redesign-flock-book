<?php

    class Livestock extends Db{

        // -- Get all livestock ------------------------------------------------
            public function getAllLivestock(){
                $this -> connect();
                    $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_sale, breed.breed_name AS breed, species.species AS species
                                FROM livestock
                                INNER JOIN species ON species.id = livestock.species
                                INNER JOIN breed ON breed.id = livestock.breed
                                ORDER BY species, livestock_name";

                    $sql = self::$conn -> prepare($query);
                    $sql->execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p>[$row[species]] [$row[breed]] - <strong>$row[livestock_name]</strong> $row[uk_tag_no] [$row[date_of_sale]]</p>";
                    }

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count livestock --------------------------------------------------
            public function countLivestock($varient){
                switch($varient){
                    case 'all':
                        $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1";
                    break;
                    case 'alive':
                        $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null";
                    break;
                    case 'dead':
                        $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS NOT null";
                    break;
                    case 'female':
                        $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 2";
                    break;
                    case 'male':
                        $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 1";
                    break;
                }
                $this -> connect();

                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['livestockCount'];

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

    }

?>
