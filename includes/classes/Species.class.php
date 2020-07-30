<?php

    class Species extends Db{

        // -- Add species form -------------------------------------------------
            public function form_addSpecies(){
                $form_element = new FormElements();
                echo "<div class='form_container add_species'>";
                    echo "<h3>Add species</h3>";
                    echo "<form name='add_species' class='col_3 js_form' data-action='add_species'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '');
                            $form_element -> input('text', 'species_name', 'Name', true, 'required', 'Please enter a Name');
                            $form_element -> input('textarea', 'species_notes', 'Notes', false, '', '');
                            $form_element -> input('control', '', 'Add Species', false, '', '');
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

    }

?>
