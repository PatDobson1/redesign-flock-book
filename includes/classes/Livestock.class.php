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
                                ORDER BY species, livestock_name";

                    $sql = self::$conn -> prepare($query);
                    $sql->execute();
                    while( $row = $sql -> fetch() ){
                        echo "<p>[$row[species]] [$row[breed]] - <strong>$row[livestock_name]</strong> $row[uk_tag_no] [$row[date_of_sale]]</p>";
                    }
                    echo "<p><em>Limited to $limit results</em></p>";

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Animal search ----------------------------------------------------
            public function animalSearchCard($site_data){
                // $type, $name, $text, $required, $validation, $error, $selectOptions
                $form_element = new FormElements();
                echo "<div class='form_container inline'>";
                    echo "<h2>Livestock search</h2>";
                    echo "<form name='search_livestock' class='js_form' data-action='search_livestock'>";
                        echo "<div>";
                            $form_element -> input('text', 'free_text', 'Text (name/tag)', false, '', '', '');
                            $form_element -> input('submit', '', 'Search', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
                echo "<div class='card search_results'></div>";

            }
        // ---------------------------------------------------------------------

        // -- Livestock filters ------------------------------------------------
            private function livestockFilter($sql, $breed_selected, $species_selected, $year_selected){
                $species_name = array('');
                $species_id = array('');
                $breeds_name = array('');
                $breeds_id = array('');
                $years = array('');
                while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                    if( array_search($row['species'], $species_name) == 0 ){
                        array_push($species_name, $row['species']);
                        array_push($species_id, $row['species_id']);
                    }
                    if( array_search($row['breed'], $breeds_name) == 0 ){
                        array_push($breeds_name, $row['breed']);
                        array_push($breeds_id, $row['breed_id']);
                    }
                    // $date =
                    $year = date("Y",strtotime($row['date_of_birth']));
                    if( array_search($year, $years) == 0 ){
                        array_push($years, $year);
                    }
                }
                array_shift($years);
                rsort($years);
                array_shift($species_name);
                array_shift($species_id);
                array_shift($breeds_name);
                array_shift($breeds_id);

                $breeds_select = "<select name='breed'>";
                    $breeds_select .= "<option value=''>Select a breed</option>";
                    foreach( $breeds_name as $key => $value ){
                        $selected = ($breeds_id[$key] == $breed_selected) ? ' selected="selected"' : '';
                        $breeds_select .= "<option value='$breeds_id[$key]' $selected>$value</option>";
                    }
                $breeds_select .= "</select>";

                $species_select = "<select name='species'>";
                    $species_select .= "<option value=''>Select a species</option>";
                    foreach( $species_name as $key => $value ){
                        $selected = ($species_id[$key] == $species_selected) ? ' selected="selected"' : '';
                        $species_select .= "<option value='$species_id[$key]' $selected>$value</option>";
                    }
                $species_select .= "</select>";

                $years_select = "<select name='year'>";
                    $years_select .= "<option value=''>Select a birth year</option>";
                    foreach( $years as $key => $value ){
                        $selected = ($value == $year_selected) ? ' selected="selected"' : '';
                        $years_select .= "<option value='$value' $selected>$value</option>";
                    }
                $years_select .= "</select>";

                $filter = "<div class='filter js-filter'>";
                    $filter .= "<h3>Filter results</h3>";
                    $filter .= "<form name='filter_results' class='js_form' data-action='filter_results'>";
                        $filter .= $breeds_select;
                        $filter .= $species_select;
                        $filter .= $years_select;
                        $filter .= "<input type='button' value='Clear' class='js_clearFilters' />";
                    $filter .= "</form>";
                $filter .= "</div>";

                return $filter;

            }
        // ---------------------------------------------------------------------

        // -- Livestock card ---------------------------------------------------
            public function liveStockCard($sortable){
                echo "<div class='livestock_data'>";
                    $sortable = $sortable ? 'sortable' : '';
                    $this -> connect();
                        $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_birth,
                                           breed.breed_name AS breed, species.species AS species, species.id AS species_id,
                                           breed.id AS breed_id, livestock.id
                                    FROM livestock
                                    INNER JOIN species ON species.id = livestock.species
                                    INNER JOIN breed ON breed.id = livestock.breed
                                    ORDER BY species, livestock_name";

                        $sql = self::$conn -> prepare($query);
                        $sql->execute();
                        echo $this -> livestockFilter($sql, null, null, null);
                        $sql -> execute();
                    $this -> disconnect();

                    echo "  <table class='$sortable'>
                                <tr>
                                    <th>Tag No.</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Species</th>
                                    <th>Breed</th>
                                    <th class='no_sort'></th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        // $data_tag = $edit ? "data-editid = '$row[id]' data-form='edit_breed' data-table='breed' class='js_edit'" : '';
                        echo "  <tr data-id='$row[id]' class='js-view'>
                                    <td class='left'>$row[uk_tag_no]</td>
                                    <td class='left'>$row[livestock_name]</td>
                                    <td class='cen'>$row[date_of_birth]</td>
                                    <td class='left'>$row[species]</td>
                                    <td class='left'>$row[breed]</td>
                                    <td><span class='icon icon_quickView js-quickView' data-id='$row[id]'></span></td>
                                </tr>";
                    }
                    echo "</table>";
                echo "</div>";

            }
        // ---------------------------------------------------------------------

        // -- Filter livestock -------------------------------------------------
            public function livestock_filter($form_data){
                $breed = ($form_data[0]['value'] == '') ? 'livestock.breed' : $form_data[0]['value'];
                $species = ($form_data[1]['value'] == '') ? 'livestock.species' : $form_data[1]['value'];
                $year = ($form_data[2]['value'] == '') ? 'YEAR(livestock.date_of_birth)' : $form_data[2]['value'];

                $this -> connect();

                    $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_birth,
                                       breed.breed_name AS breed, species.species AS species, species.id AS species_id,
                                       breed.id AS breed_id, livestock.id
                                FROM livestock
                                INNER JOIN species ON species.id = livestock.species
                                INNER JOIN breed ON breed.id = livestock.breed
                                WHERE livestock.breed = :breed AND livestock.species = :species AND YEAR(livestock.date_of_birth) = :year
                                ORDER BY species, livestock_name";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':year', $year);
                    $sql -> bindParam(':breed', $breed);

                    $sql -> execute();

                    $html = "  <table class='sortable'>
                                <tr>
                                    <th>Tag No.</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Species</th>
                                    <th>Breed</th>
                                    <th class='no_sort'></th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        $html .= "  <tr data-id='$row[id]' class='js-view'>
                                    <td class='left'>$row[uk_tag_no]</td>
                                    <td class='left'>$row[livestock_name]</td>
                                    <td class='cen'>$row[date_of_birth]</td>
                                    <td class='left'>$row[species]</td>
                                    <td class='left'>$row[breed]</td>
                                    <td><span class='icon icon_quickView js-quickView' data-id='$row[id]'></span></td>
                                </tr>";
                    }
                    $html .= "</table>";

                    $output = new stdClass();
                    $output -> action = 'livestockFiltered';
                    $output -> html = $html;
                    $sql -> execute();
                    $output -> filter = $this -> livestockFilter($sql, $breed, $species, $year);
                    echo json_encode($output);
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Animal -----------------------------------------------------------
            public function animalCard($site_data, $id){
                $this -> connect();
                    $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_birth, livestock.id,
                                       livestock.date_of_death, livestock.date_of_sale, livestock.mother, livestock.father,
                                       livestock.pedigree_no, livestock.home_bred, livestock.for_slaughter, livestock.origin,
                                       livestock.notes, livestock.previous_tags,
                                       breed.breed_name AS breed,
                                       species.species AS species,
                                       gender.gender AS gender
                                FROM livestock
                                INNER JOIN species ON species.id = livestock.species
                                INNER JOIN breed ON breed.id = livestock.breed
                                INNER JOIN gender ON gender.id = livestock.gender
                                WHERE :id = livestock.id
                                ORDER BY species, livestock_name";

                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql->execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $name = $row['livestock_name'] ? $row['livestock_name'] : 'n/a';
                $date_of_death = $row['date_of_death'] ? $row['date_of_death'] : 'n/a';
                $date_of_sale = $row['date_of_sale'] ? $row['date_of_sale'] : 'n/a';
                $pedigree_number = $row['pedigree_no'] ? $row['pedigree_no'] : 'n/a';
                $home_bred = $row['home_bred'] ? '<span class="icon icon_tick"><span>' : '<span class="icon icon_cross"></span>';
                $for_slaughter = $row['for_slaughter'] ? '<span class="icon icon_tick"></span>' : '<span class="icon icon_cross"></span>';
                $origin = $row['origin'] ? $row['origin'] : 'n/a';
                $mother = $this -> getParent($row['mother']);
                $mother = $mother ? "<span class='icon icon_quickView js-quickView' data-id='$row[mother]'></span> <a href='$site_data[site_root]/livestock?id=$row[mother]' class='link'>$mother</a>" : 'n/a';
                $father = $this -> getParent($row['father']);
                $father = $father ? "<span class='icon icon_quickView js-quickView' data-id='$row[father]'></span> <a href='$site_data[site_root]/livestock?id=$row[father]' class='link'>$father</a>" : 'n/a';
                $previous_tags = $row['previous_tags'] ? $row['previous_tags'] : 'n/a';

                echo "<p><a href='$site_data[site_root]/livestock' class='back'>Back to livestock</a></p>";

                echo "<div class='card'>";
                echo "  <h2>Stock details</h2>";
                echo "  <div class='col_2'>";
                echo "      <div>";
                echo "          <p><label>Name:</label>$name</p>";
                echo "          <p><label>Species:</label>$row[species]</p>";
                echo "          <p><label>Breed:</label>$row[breed]</p>";
                echo "          <p><label>Tag:</label>$row[uk_tag_no]</p>";
                echo "          <p><label>Pedigree number:</label>$pedigree_number</p>";
                echo "          <p><label>Home bred:</label>$home_bred</p>";
                echo "          <p><label>For slaughter:</label>$for_slaughter</p>";
                echo "      </div>";
                echo "      <div>";
                echo "          <p><label>Mother:</label>$mother</p>";
                echo "          <p><label>Father:</label>$father</p>";
                echo "          <p><label>Gender:</label>$row[gender]</p>";
                echo "          <p><label>Date of birth:</label>$row[date_of_birth]</p>";
                echo "          <p><label>Date of death:</label>$date_of_death</p>";
                echo "          <p><label>Date of sale:</label>$date_of_sale</p>";
                echo "      </div>";
                echo "  </div>";
                echo "  <div>";
                echo "      <p><label>Previous tags:</label>$previous_tags</p>";
                echo "      <p><label>Origin:</label>$origin</p>";
                echo "      <p><label>Notes:</label>$row[notes]</p>";
                echo "  </div>";
                echo "</div>";

            }
        // ---------------------------------------------------------------------

        // -- Animal quick view ------------------------------------------------
            public function animalQuickView($site_data, $id){
                $this -> connect();
                    $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_birth, livestock.id,
                                       livestock.date_of_death, livestock.date_of_sale, livestock.mother, livestock.father,
                                       livestock.pedigree_no, livestock.home_bred, livestock.for_slaughter, livestock.origin,
                                       livestock.notes, livestock.previous_tags,
                                       breed.breed_name AS breed,
                                       species.species AS species,
                                       gender.gender AS gender
                                FROM livestock
                                INNER JOIN species ON species.id = livestock.species
                                INNER JOIN breed ON breed.id = livestock.breed
                                INNER JOIN gender ON gender.id = livestock.gender
                                WHERE :id = livestock.id
                                ORDER BY species, livestock_name";

                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql->execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $name = $row['livestock_name'] ? $row['livestock_name'] : 'n/a';
                $date_of_death = $row['date_of_death'] ? $row['date_of_death'] : 'n/a';
                $date_of_sale = $row['date_of_sale'] ? $row['date_of_sale'] : 'n/a';
                $pedigree_number = $row['pedigree_no'] ? $row['pedigree_no'] : 'n/a';
                $home_bred = $row['home_bred'] ? '<span class="icon icon_tick"><span>' : '<span class="icon icon_cross"></span>';
                $for_slaughter = $row['for_slaughter'] ? '<span class="icon icon_tick"></span>' : '<span class="icon icon_cross"></span>';
                $origin = $row['origin'] ? $row['origin'] : 'n/a';
                $mother = $this -> getParent($row['mother']);
                $mother = $mother ? "<a href='$site_data[site_root]/livestock?id=$row[mother]' class='inline'>$mother</a>" : 'n/a';
                $father = $this -> getParent($row['father']);
                $father = $father ? "<a href='$site_data[site_root]/livestock?id=$row[father]' class='inline'>$father</a>" : 'n/a';
                $previous_tags = $row['previous_tags'] ? $row['previous_tags'] : 'n/a';

                echo "<div class='modalScroll'>";
                echo "<div>";
                echo "  <p><label>Name:</label><span>$name</span></p>";
                echo "  <p><label>Species:</label><span>$row[species]</span></p>";
                echo "  <p><label>Breed:</label><span>$row[breed]</span></p>";
                echo "  <p><label>Tag:</label><span>$row[uk_tag_no]</span></p>";
                echo "  <p><label>Pedigree number:</label><span>$pedigree_number</span></p>";
                echo "  <p><label>Home bred:</label><span>$home_bred</span></p>";
                echo "  <p><label>For slaughter:</label><span>$for_slaughter</span></p>";
                echo "  <p><label>Mother:</label><span>$mother</span></p>";
                echo "  <p><label>Father:</label><span>$father</span></p>";
                echo "  <p><label>Gender:</label><span>$row[gender]</span></p>";
                echo "  <p><label>Date of birth:</label><span>$row[date_of_birth]</span></p>";
                echo "  <p><label>Date of death:</label><span>$date_of_death</span></p>";
                echo "  <p><label>Date of sale:</label><span>$date_of_sale</span></p>";
                echo "</div>";
                echo "<div>";
                echo "  <p><label>Previous tags:</label><span>$previous_tags</span></p>";
                echo "  <p><label>Origin:</label><span>$origin</span></p>";
                echo "  <p><label>Notes:</label><span>$row[notes]</span></p>";
                echo "</div>";
                echo "</div>";

            }
        // ---------------------------------------------------------------------

        // -- Siblings ---------------------------------------------------------
            public function siblingsCard($site_data, $id){

                $this -> connect();

                    $query = "SELECT mother, father FROM livestock WHERE :id = id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $mother = $row['mother'];
                        $father = $row['father'];
                    }

                    $query = "  SELECT a.id, a.livestock_name, b.livestock_name AS mother_name, c.livestock_name AS father_name, a.uk_tag_no, a.date_of_birth,
                                       breed.breed_name AS breed_name, a.mother, a.father
                					FROM livestock a
                					LEFT OUTER JOIN livestock b ON a.mother = b.id
                					LEFT OUTER JOIN livestock c ON a.father = c.id
                				 	INNER JOIN breed ON a.breed = breed.id
                					WHERE
                						( ( a.mother = :mother AND a.mother != 0 ) OR ( a.father = :father AND a.father != 0 ) )
                						AND a.id != :id
                						AND a.deleted = 0";

                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':mother', $mother);
                    $sql -> bindParam(':father', $father);
                    $sql->execute();
                    $count = $sql -> rowCount();

                $this -> disconnect();

                echo "<div class='card'>";
                if($count){
                    echo "  <h2>Siblings</h2>";
                    echo "  <table class='sortable'>";
                    echo "      <tr>";
                    echo "          <th>Tag</th>";
                    echo "          <th>Name</th>";
                    echo "          <th>Mother</th>";
                    echo "          <th>Father</th>";
                    echo "          <th>Date of birth</th>";
                    echo "          <th>Breed</th>";
                    echo "          <th class='no_sort'></th>";
                    echo "      </tr>";
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        echo "  <tr data-id='$row[id]' class='js-view'>";
                        echo "      <td>$row[uk_tag_no]</td>";
                        echo "      <td>$row[livestock_name]</td>";
                        echo "      <td>$row[mother_name]</td>";
                        echo "      <td>$row[father_name]</td>";
                        echo "      <td>$row[date_of_birth]</td>";
                        echo "      <td>$row[breed_name]</td>";
                        echo "      <td><span class='icon icon_quickView js-quickView' data-id='$row[id]'></span></td>";
                        echo "  </tr>";
                    }
                    echo "  </table>";
                }else{
                    echo "<p class='none'>No siblings</p>";
                }
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Children ---------------------------------------------------------
            public function childrenCard($site_data, $id){

                 $this -> connect();

                     $query = " SELECT a.id, a.livestock_name, a.uk_tag_no, a.date_of_birth,
                 				       b.livestock_name AS mother_name, c.livestock_name AS father_name,
                                       breed.breed_name AS breed_name, a.mother, a.father
                                FROM livestock a
                 				LEFT OUTER JOIN livestock b on a.mother = b.id
                 				LEFT OUTER JOIN livestock c on a.father = c.id
                 				INNER JOIN breed on a.breed = breed.id
                 				WHERE (a.father = :father OR a.mother = :mother) AND a.deleted = 0";
                     $sql = self::$conn -> prepare($query);
                     $sql -> bindParam(':mother', $id);
                     $sql -> bindParam(':father', $id);
                     $sql -> execute();
                     $count = $sql -> rowCount();

                 $this -> disconnect();

                 echo "<div class='card'>";
                 if($count){
                     echo "  <h2>Children</h2>";
                     echo "  <table class='sortable'>";
                     echo "      <tr>";
                     echo "          <th>Tag</th>";
                     echo "          <th>Name</th>";
                     echo "          <th>Mother</th>";
                     echo "          <th>Father</th>";
                     echo "          <th>Date of birth</th>";
                     echo "          <th>Breed</th>";
                     echo "          <th class='no_sort'></th>";
                     echo "      </tr>";
                     while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                         echo "  <tr data-id='$row[id]' class='js-view'>";
                         echo "      <td>$row[uk_tag_no]</td>";
                         echo "      <td>$row[livestock_name]</td>";
                         echo "      <td>$row[mother_name]</td>";
                         echo "      <td>$row[father_name]</td>";
                         echo "      <td>$row[date_of_birth]</td>";
                         echo "      <td>$row[breed_name]</td>";
                         echo "      <td><span class='icon icon_quickView js-quickView' data-id='$row[id]'></span></td>";
                         echo "  </tr>";
                     }
                     echo "  </table>";
                 }else{
                     echo "<p class='none'>No children</p>";
                 }
                 echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Family tree ------------------------------------------------------
            public function familyTree($site_data, $id){

                echo "<div class='card'>";
                echo "  <h2>Family tree</h2>";
                echo "  <div class='family_tree' data-id='$id'></div>";
                echo "<div class='treeKey'>";
                    echo "<div><span class='key_ram'></span>Ram</div>";
                    echo "<div><span class='key_ewe'></span>Ewe</div>";
                    echo "<div><p class='key_alive'></p>Alive</div>";
                    echo "<div><p class='key_dead'></p>Dead</div>";
                    echo "<div><p class='key_unknown'></p>Unknown</div>";
                echo "</div>";
                echo "</div>";

            }
            public function buildFamilyTree(){

                $this -> connect();

                    $query = "SELECT id, livestock_name, mother, father, gender, uk_tag_no, date_of_death
                                 FROM livestock
                                 WHERE deleted = 0";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                $this -> disconnect();

                $return = array();

                while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                    // -- Cast output numbers to integers ----
                        $row['id'] = (int)$row['id'];
                        $row['father'] = (int)$row['father'];
                        $row['mother'] = (int)$row['mother'];
                    // ---------------------------------------
                	$return[] = $row;
                }

                echo json_encode($return);

            }
        // ---------------------------------------------------------------------

        // -- Diary card -------------------------------------------------------
            public function diaryCard($id){
                echo "<div class='card'>";
                echo "  <h2>Diary</h2>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Get parent -------------------------------------------------------
            public function getParent($id){
                $this -> connect();
                    $query = "  SELECT * FROM livestock WHERE :id = id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql->execute();
                    $output = '';
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        if( $row['livestock_name'] && $row['uk_tag_no'] ){
                            $string = "$row[uk_tag_no] ( $row[livestock_name] )";
                        }elseif (!$row['uk_tag_no']){
                            $string = $row['livestock_name'];
                        }else{
                            $row['uk_tag_no'];
                        }
                        // $string = $row['livestock_name'] ? "$row[uk_tag_no] ( $row[livestock_name] )" : "$row[uk_tag_no]";
                        $output .= $string;
                    }
                    return $output;
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Count all livestock ----------------------------------------------
            // -- NOT USED -- //
            // public function countLivestock($varient){
            //     switch($varient){
            //         case 'all':
            //             $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1";
            //         break;
            //         case 'alive':
            //             $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null";
            //         break;
            //         case 'dead':
            //             $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS NOT null";
            //         break;
            //         case 'female':
            //             $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 2";
            //         break;
            //         case 'male':
            //             $query = "SELECT COUNT(id) AS livestockCount FROM livestock WHERE deleted != 1 AND date_of_death IS null AND gender = 1";
            //         break;
            //     }
            //     $this -> connect();
            //
            //         $sql = self::$conn -> prepare($query);
            //         $sql -> execute();
            //         $row = $sql -> fetch();
            //         return $row['livestockCount'];
            //
            //     $this -> disconnect();
            // }
        // ---------------------------------------------------------------------

    }

?>
