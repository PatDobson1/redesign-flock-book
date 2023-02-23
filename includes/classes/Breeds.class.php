<?php

    class Breeds extends Db{

        // -- Breeds card ------------------------------------------------------
            public function simpleBreedCard($sortable){
                $sortable = $sortable ? 'sortable' : '';
                $query = "  SELECT DISTINCT(breed.breed_name), breed.id AS breedId, livestock.species AS speciesId
                            FROM breed
                            INNER JOIN livestock ON breed.id = livestock.breed
                            ORDER BY livestock.species, breed ";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table class='$sortable'>
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

        // -- Single breed card ----------------------------------------------
            public function singleBreedCard($site_data, $id, $context){

                $this -> connect();
                    $query = "SELECT * FROM breed WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $data = '';
                $data .= "<p class='controls'>";
                    $data .= "<a href='$site_data[site_root]/breeds' class='back'>Back to breeds</a>";
                    $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='breed' data-form='edit_breed'>Edit breed</a>";
                $data .= "</p>";

                $data .= "<div class='card breedCard'>";
                    $data .= "<h2>Breed details</h2>";
                    $data .= "<div class='col_2'>";
                        $data .= "<div>";
                            $data .= "<p><label>Breed name:</label>$row[breed_name]</p>";
                            $data .= "<p><label>Species:</label>" . $this -> getSpecies($row['species']) . "</p>";
                        $data.= "</div>";
                    $data .= "</div>";
                    $data .= "<div>";
                        $data .= "<p class='fullWidth'><label>Notes:</label>$row[notes]</p>";
                    $data .= "</div>";
                $data .= "</div>";

                if($context == 'echo'){
                    echo $data;
                }else{
                    return $data;
                }

            }
        // ---------------------------------------------------------------------

        // -- Simple breeds card ------------------------------------------------------
            public function breedCard($edit){
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
                                    <th>Female</th>
                                    <th>Male</th>
                                    <th>Total</th>
                                    <th class='delete_col no_sort'></th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        $data_tag = $edit ? "data-id = '$row[id]' class='js-view'" : '';
                        $species = $this -> getSpecies($row['species']);
                        $breedCount_female = $this -> countBreed($row['id'],2);
                        $breedCount_male = $this -> countBreed($row['id'],1);
                        $breedCount_total = $breedCount_female + $breedCount_male;
                        if( $breedCount_total === 0 ){
                            $edit_cell = "<td><a class='js-delete delete_link' data-id='$row[id]' data-deletetype='breed'>Delete</a></td>";
                        }else{
                            $edit_cell = '<td></td>';
                        }
                        echo "  <tr $data_tag>
                                    <td class='left'>$row[breed_name]</td>
                                    <td class='left'>$species</td>
                                    <td>$breedCount_female</td>
                                    <td>$breedCount_male</td>
                                    <td>$breedCount_total</td>
                                    $edit_cell
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
                $generic = new Generic();
                $form_element = new FormElements();
                echo "<div class='form_container add_breed form_hide'>";
                    echo "<h3>Add breed</h3>";
                    echo "<form name='add_breed' class='col_3 js_form' data-action='add_breed'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('breed_name', 'Name', true, 'required', 'Please enter a Name');
                            $form_element -> select('species', 'Species', true, 'required', 'Please select a species', $generic -> getSpeciesList());
                            $form_element -> textarea('breed_notes', 'Notes', false, '', '');
                            $form_element -> submit('Add Breed');
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

        // -- Edit breed form --------------------------------------------------
            public function form_editBreed(){
                $form_element = new FormElements();
                $generic = new Generic();
                echo "<div class='form_container edit_breed form_hide'>";
                    echo "<h3>Edit breed</h3>";
                    echo "<form name='edit_breed' class='col_3 js_form' data-action='edit_breed'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('breed_name', 'Name', true, 'required', 'Please enter a Name');
                            $form_element -> select('species', 'Species', false, '', '', $generic -> getSpeciesList());
                            $form_element -> textarea('breed_notes', 'Notes', false, '', '');
                            $form_element -> hidden('breed_id');
                            $form_element -> submit('Edit Breed');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Edit breed -------------------------------------------------------
            public function sql_editBreed($form_data){
                $name = $form_data[0]['value'];
                $species = $form_data[1]['value'];
                $notes = $form_data[2]['value'];
                $id = $form_data[3]['value'];
                $this -> connect();
                    $query = "UPDATE breed
                              SET breed_name = :name,
                                  species = :species,
                                  notes = :notes
                              WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':name', $name);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'breedEdited';
                $output -> name = $name;
                $output -> species = $this -> getSpecies($species);
                $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Get breed --------------------------------------------------------
            public function sql_getBreed($id){
                $this -> connect();
                    $query = "SELECT * FROM breed WHERE :id = id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                    $output -> breed_id = $row['id'];
                    $output -> breed_name = $row['breed_name'];
                    $output -> species = $row['species'];
                    $output -> breed_notes = $row['notes'];
                    $output -> context = 'editBreed';
                    echo json_encode($output);
                }
            }
        // ---------------------------------------------------------------------

        // -- Delete breed -----------------------------------------------------
            public function sql_deleteBreed($form_data){
                $id = $form_data[0]['value'];
                $this -> connect();
                    $query = "DELETE FROM breed WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'breedDeleted';
                $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

    }

?>
