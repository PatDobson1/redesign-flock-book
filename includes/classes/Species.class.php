<?php

    class Species extends Db{

        // -- Add species form -------------------------------------------------
            public function form_addSpecies(){
                echo "<div class='form_container add_species'>";
                    echo "<h3>Add species</h3>";
                    echo "<form name='add_species' class='col_3 js_form' data-action='add_species'>";
                        echo "<div>";
                            echo "<p>";
                                echo "<label for='species_name'>Name</label>";
                                echo "<input type='text' name='species_name' />";
                            echo "</p>";
                            echo "<p>";
                                echo "<label for='species_notes'>Notes</label>";
                                echo "<textarea name='species_notes'></textarea>";
                            echo "</p>";
                            echo "<p class='form_control'>";
                                echo "<input type='submit' value='Add species' />";
                                echo "<input type='reset' value='Reset' />";
                            echo "</p>";
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
