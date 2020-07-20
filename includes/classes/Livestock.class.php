<?php

    class Livestock extends Db{

        // -- Get all livestock ------------------------------------------------
            public function getAllLivestock(){
                $limit = 10;
                $this -> connect();
                    $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_sale,
                                       breed.breed_name AS breed, species.species AS species
                                FROM livestock
                                INNER JOIN species ON species.id = livestock.species
                                INNER JOIN breed ON breed.id = livestock.breed
                                ORDER BY species, livestock_name
                                LIMIT $limit";

                    $sql = self::$conn -> prepare($query);
                    $sql->execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p>[$row[species]] [$row[breed]] - <strong>$row[livestock_name]</strong> $row[uk_tag_no] [$row[date_of_sale]]</p>";
                    }
                    echo "<p><em>Limited to $limit results</em></p>";

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get species ------------------------------------------------------
            public function getSpecies(){
                $livestock = new Livestock();
                $this -> connect();
                    $query = "SELECT * FROM species ORDER by species";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p>";
                            echo $row['species'] . " :: " . $livestock -> countSpecies($row['id']);
                        echo "</p>";
                    }
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count species ----------------------------------------------------
            public function countSpecies($species){
                $query = "SELECT COUNT(id) as speciesCount FROM livestock WHERE :species = species AND deleted != 1 AND date_of_death IS null";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['speciesCount'];
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count all livestock ----------------------------------------------
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
