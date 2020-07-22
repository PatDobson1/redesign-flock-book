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

        // -- Species card -----------------------------------------------------
            public function speciesCard(){
                $this -> connect();
                    $query = "SELECT * FROM species ORDER by species";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table>
                                <tr>
                                    <th>Species</th>
                                    <th>Female</th>
                                    <th>Male</th>
                                    <th>Total</th>
                                </tr>";
                                    while( $row = $sql -> fetch() ){
                                        $livestockCount_male = $this -> countSpecies($row['id'],1);
                                        $livestockCount_female = $this -> countSpecies($row['id'],2);
                                        $livestockCount = $livestockCount_female + $livestockCount_male;
                                        echo " <tr>
                                                    <td class='left'>$row[species]</td>
                                                    <td>$livestockCount_female</td>
                                                    <td>$livestockCount_male</td>
                                                    <td>$livestockCount</td>
                                                </tr>";
                                    }
                    echo "  </table>";
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Breeds card ------------------------------------------------------
            public function breedCard(){
                $query = "  SELECT DISTINCT(breed.breed_name), breed.id AS breedId, livestock.species AS speciesId
                            FROM breed
                            INNER JOIN livestock ON breed.id = livestock.breed
                            ORDER BY species, breed ";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table class='sortable'>
                                <tr>
                                    <th>Breed</th>
                                    <th>Species</th>
                                    <th>Female</th>
                                    <th>Male</th>
                                    <th>Total</th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        $species = $this -> getSpecies($row['speciesId']);
                        $breedCount_female = $this -> countBreed($row['breedId'],2);
                        $breedCount_male = $this -> countBreed($row['breedId'],1);
                        $breedCount_total = $breedCount_female + $breedCount_male;
                        echo "  <tr>
                                    <td class='left'>$row[breed_name]</td>
                                    <td class='left'>$species</td>
                                    <td>$breedCount_female</td>
                                    <td>$breedCount_male</td>
                                    <td>$breedCount_total</td>
                                </tr>";
                    }
                    echo "  </table>";
                $this -> disconnect();
            }
            public function getSpecies($id){
                $query = "SELECT species FROM species WHERE :id = id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['species'];
                $this -> disconnect();
            }
            public function countBreed($breed,$gender){
                $query = "  SELECT COUNT(id) AS breedCount
                            FROM livestock
                            WHERE :breed = breed AND :gender = gender
                                    AND date_of_death IS null
                                    AND date_of_sale IS null
                                    AND deleted = 0";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':breed', $breed);
                    $sql -> bindParam(':gender', $gender);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['breedCount'];
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count species ----------------------------------------------------
            public function countSpecies($species, $gender){
                $query = "  SELECT COUNT(id) as speciesCount
                            FROM livestock
                            WHERE :species = species
                                    AND :gender = gender
                                    AND deleted != 1
                                    AND date_of_death IS null
                                    AND date_of_sale IS null";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':gender', $gender);
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
