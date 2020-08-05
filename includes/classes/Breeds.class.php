<?php

    class Breeds extends Db{

        // -- Breeds card ------------------------------------------------------
            public function breedCard(){
                $query = "  SELECT DISTINCT(breed.breed_name), breed.id AS breedId, livestock.species AS speciesId
                            FROM breed
                            INNER JOIN livestock ON breed.id = livestock.breed
                            ORDER BY livestock.species, breed ";
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
        // ---------------------------------------------------------------------

        // -- Simple breeds card ------------------------------------------------------
            public function simpleBreedCard(){
                $query = "  SELECT *
                            FROM breed
                            ORDER BY species,breed_name";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table class='sortable simple_breed_table'>
                                <tr>
                                    <th>Breed</th>
                                    <th>Species</th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        $species = $this -> getSpecies($row['species']);
                        echo "  <tr>
                                    <td class='left'>$row[breed_name]</td>
                                    <td class='left'>$species</td>
                                </tr>";
                    }
                    echo "  </table>";
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get species based on id ------------------------------------------
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
        // ---------------------------------------------------------------------

        // -- Get species list [select options ] -------------------------------
            public function getSpeciesList(){
                $query = "SELECT id AS value, species AS text FROM species ORDER BY species";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $results = array();
                    $output = '';
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output .= "<option value='$row[value]'>$row[text]</option>";
                    }
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Count breed ------------------------------------------------------
            public function countBreed($breed, $gender){
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

        // -- Add breed form ---------------------------------------------------
            public function form_addBreed(){
                $form_element = new FormElements();
                echo "<div class='form_container add_breed form_hide'>";
                    echo "<h3>Add breed</h3>";
                    echo "<form name='add_breed' class='col_3 js_form' data-action='add_breed'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('text', 'breed_name', 'Name', true, 'required', 'Please enter a Name','');
                            $form_element -> input('select', 'species', 'Species', false, '', '', $this -> getSpeciesList());
                            $form_element -> input('textarea', 'breed_notes', 'Notes', false, '', '','');
                            $form_element -> input('control', '', 'Add Breed', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add breed --------------------------------------------------------
            public function sql_addBreed($form_data){
                $name = $form_data[0]['value'];
                $species = $form_data[1]['value'];
                $notes = $form_data[2]['value'];
                $this -> connect();
                    $query = "INSERT INTO breed (breed_name, species, notes)
                              VALUES (:name, :species, :notes)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':name', $name);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'breedAdded';
                $output -> name = $name;
                $output -> species = $this -> getSpecies($species);
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

    }

?>
