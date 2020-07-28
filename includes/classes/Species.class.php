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

    }

?>
