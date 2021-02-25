<?php

    class Species extends Db{

        // -- Species card -----------------------------------------------------
            public function speciesCard($edit){
                $this -> connect();
                    $query = "SELECT * FROM species ORDER by species";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $edit_col = $edit ? '<th class="delete_col"></th>' : '';
                    echo "  <table class='species_table'>
                                <tr>
                                    <th>Species</th>
                                    <th>Breeds</th>
                                    <th>Female</th>
                                    <th>Male</th>
                                    <th>Total</th>
                                    $edit_col
                                </tr>";
                                    while( $row = $sql -> fetch() ){
                                        $data_tag = $edit ? "data-editid = '$row[id]' data-form='edit_species' data-table='species' class='js_edit'" : '';
                                        $livestockCount_male = $this -> countSpecies($row['id'],1);
                                        $livestockCount_female = $this -> countSpecies($row['id'],2);
                                        $livestockCount = $livestockCount_female + $livestockCount_male;
                                        $breedCount = $this -> countBreeds($row['id']);
                                        if( $edit && ($livestockCount == 0 && $breedCount == 0) ){
                                            $edit_cell = "<td><a class='js-delete delete_link' data-id='$row[id]' data-deletetype='species'>Delete</a></td>";
                                        }elseif( $edit && ($livestockCount > 0 || $breedCount > 0) ){
                                            $edit_cell = '<td></td>';
                                        }else{
                                            $edit_cell = '';
                                        }

                                        echo " <tr $data_tag>
                                                    <td class='left'>$row[species]</td>
                                                    <td>$breedCount</td>
                                                    <td>$livestockCount_female</td>
                                                    <td>$livestockCount_male</td>
                                                    <td>$livestockCount</td>
                                                    $edit_cell
                                                </tr>";
                                    }
                    echo "  </table>";
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get breeds based on id -------------------------------------------
            public function countBreeds($species){
                $query = "SELECT COUNT(id) AS breedCount FROM breed WHERE :species = species";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
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

        // -- Add species form -------------------------------------------------
            public function form_addSpecies(){
                $form_element = new FormElements();
                echo "<div class='form_container add_species form_hide'>";
                    echo "<h3>Add species</h3>";
                    echo "<form name='add_species' class='col_3 js_form' data-action='add_species'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '', '');
                            $form_element -> input('text', 'species_name', 'Name', true, 'required', 'Please enter a Name', '');
                            $form_element -> input('textarea', 'species_notes', 'Notes', false, '', '', '');
                            $form_element -> input('submit', '', 'Add Species', false, '', '', '');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Edit species form ------------------------------------------------
            public function form_editSpecies(){
                $form_element = new FormElements();
                echo "<div class='form_container edit_species form_hide'>";
                    echo "<h3>Edit species</h3>";
                    echo "<form name='edit_species' class='col_3 js_form' data-action='edit_species'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '', '');
                            $form_element -> input('hidden', 'species_id', '', false, '', '', '');
                            $form_element -> input('text', 'species_name', 'Name', true, 'required', 'Please enter a Name', '');
                            $form_element -> input('textarea', 'species_notes', 'Notes', false, '', '', '');
                            $form_element -> input('control', '', 'Edit Species', false, '', '', '');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add species ------------------------------------------------------
            public function sql_addSpecies($form_data){
                $name = $form_data[0]['value'];
                $notes = $form_data[1]['value'];
                $this -> connect();
                    $query = "INSERT INTO species (species, notes)
                              VALUES (:name, :notes)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':name', $name);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'speciesAdded';
                $output -> name = $name;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Edit species -----------------------------------------------------
            public function sql_editSpecies($form_data){
                $id = $form_data[0]['value'];
                $species = $form_data[1]['value'];
                $notes = $form_data[2]['value'];

                $this -> connect();
                    $query = "UPDATE species
                              SET species = :species, notes = :notes
                              WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'speciesEdited';
                $output -> species = $species;
                $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Delete species ---------------------------------------------------
            public function sql_deleteSpecies($form_data){
                $id = $form_data[0]['value'];
                $this -> connect();
                    $query = "DELETE FROM species WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'speciesDeleted';
                $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Get species ------------------------------------------------------
            public function sql_getSpecies($id){
                $this -> connect();
                    $query = "SELECT * FROM species WHERE :id = id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                    $output -> species_id = $row['id'];
                    $output -> species_name = $row['species'];
                    $output -> species_notes = $row['notes'];
                    echo json_encode($output);
                }
            }
        // ---------------------------------------------------------------------

    }

?>
