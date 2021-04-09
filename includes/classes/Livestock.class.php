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
            private function livestockFilter(){

                $breeds_select = "<select name='breed_filter'>";
                    $breeds_select .= "<option value='null'>Select a breed</option>";
                $breeds_select .= "</select>";

                $species_select = "<select name='species_filter'>";
                    $species_select .= "<option value='null'>Select a species</option>";
                $species_select .= "</select>";

                $years_select = "<select name='year_filter'>";
                    $years_select .= "<option value='null'>Select a DOB</option>";
                $years_select .= "</select>";

                $filter = "<div class='filter js-filter'>";
                    $filter .= "<h3>Filter results</h3>";
                    $filter .= "<form name='filter_results' class='js_filter' data-action='filter_results'>";
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
                        echo $this -> livestockFilter();
                        $sql -> execute();
                    $this -> disconnect();

                    echo "  <table class='$sortable livestock_table livestockFiltered'>
                                <tr>
                                    <th>Tag No.</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Species</th>
                                    <th>Breed</th>
                                    <th class='no_sort'></th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
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

        // -- Get livestock data -----------------------------------------------
            public function sql_getLivestock($id){

                $this -> connect();
                    $query = "  SELECT * FROM livestock WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql->execute();
                    $output = new stdClass();
                    if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output -> id = $row['id'];
                        $output -> livestock_name = $row['livestock_name'];
                        $output -> species = $row['species'];
                        $output -> breed = $row['breed'];
                        $output -> uk_tag_no = $row['uk_tag_no'];
                        $output -> origin = $row['origin'];
                        $output -> date_of_birth = $row['date_of_birth'];
                        $output -> date_of_death = $row['date_of_death'];
                        $output -> date_of_sale = $row['date_of_sale'];
                        $output -> pedigree_no = $row['pedigree_no'];
                        $output -> notes = $row['notes'];
                        $output -> gender = $row['gender'];
                        $output -> mother = $row['mother'];
                        $output -> father = $row['father'];
                        $output -> home_bred = $row['home_bred'];
                        $output -> for_slaughter = $row['for_slaughter'];
                        $output -> context = 'editLivestock';
                    }
                    echo json_encode($output);
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Get livestock data -----------------------------------------------
            public function sql_getLivestockRange($ids, $site_data, $complexity){

                $this -> connect();
                    $query = "  SELECT * FROM livestock WHERE id IN($ids)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $html = '';
                    while($row = $sql -> fetch()){
                        $description = $row['livestock_name'] ? $row['livestock_name'] . ' (' . $row['uk_tag_no'] .')' : $row['uk_tag_no'];
                        if( $complexity == 'complex' ){
                            $html .= "<span><a href='$site_data[site_root]/livestock?id=$row[id]'>$description</a><a class='icon icon_quickView js-quickView' data-id='$row[id]'></a></span>";
                        }else{
                            $html .= "<li>$description</li>";
                        }

                    }
                $this -> disconnect();
                return $html;

            }
        // ---------------------------------------------------------------------

        // -- Animal -----------------------------------------------------------
            public function animalCard($site_data, $id, $context){
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
                if($row['previous_tags']){
                    $temp_tags = explode("[[~]]", $row['previous_tags']);
                    $previous_tags = "<ul class='tag_list'>";
                        foreach ($temp_tags as $value) {
                            $previous_tags .= "<li>$value</li>";
                        }
                    $previous_tags .= "</ul>";
                }else{
                    $previous_tags = 'n/a';
                }

                $data = '';
                $data.= "<p class='controls'>";
                    $data.= "<a href='$site_data[site_root]/livestock' class='back'>Back to livestock</a>";
                    $data.= "<a class='right_aligned js_edit_btn' data-editid='$row[id]' data-edittype='livestock' data-form='edit_livestock'>Edit livestock</a>";
                $data.= "</p>";

                $data.= "<div class='card animalCard'>";
                $data.= "  <h2>Stock details</h2>";
                $data.= "  <div class='col_2'>";
                $data.= "      <div>";
                $data.= "          <p><label>Name:</label>$name</p>";
                $data.= "          <p><label>Species:</label>$row[species]</p>";
                $data.= "          <p><label>Breed:</label>$row[breed]</p>";
                $data.= "          <p><label>Tag:</label>$row[uk_tag_no]</p>";
                $data.= "          <p><label>Pedigree number:</label>$pedigree_number</p>";
                $data.= "          <p><label>Home bred:</label>$home_bred</p>";
                $data.= "          <p><label>For slaughter:</label>$for_slaughter</p>";
                $data.= "      </div>";
                $data.= "      <div>";
                $data.= "          <p><label>Mother:</label>$mother</p>";
                $data.= "          <p><label>Father:</label>$father</p>";
                $data.= "          <p><label>Gender:</label>$row[gender]</p>";
                $data.= "          <p><label>Date of birth:</label>$row[date_of_birth]</p>";
                $data.= "          <p><label>Date of death:</label>$date_of_death</p>";
                $data.= "          <p><label>Date of sale:</label>$date_of_sale</p>";
                $data.= "      </div>";
                $data.= "  </div>";
                $data.= "  <div>";
                $data.= "      <p><label>Previous tags:</label>$previous_tags</p>";
                $data.= "      <p class='fullWidth'><label>Origin:</label>$origin</p>";
                $data.= "      <p class='fullWidth'><label>Notes:</label>$row[notes]</p>";
                $data.= "  </div>";
                $data.= "   <div class='deleteRow'><a class='js-delete delete_link' data-id='$row[id]' data-deletetype='livestock'>Delete</a></div>";
                $data.= "</div>";

                if($context == 'echo'){
                    echo $data;
                }else{
                    return $data;
                }

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
                    echo "<div><span class='key_ram'></span>Male</div>";
                    echo "<div><span class='key_ewe'></span>Female</div>";
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
                            $string = $row['uk_tag_no'];
                        }
                        $output .= $string;
                    }
                    return $output;
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Add livestock form -----------------------------------------------
            public function form_addLivestock(){

                $generic = new Generic();
                $form_element = new FormElements();
                $breed_list =  $generic -> getBreedList('','');
                $species_list = $generic -> getSpeciesList();
                $gender_list = $generic -> getGenderList();
                $mothers_list =  $generic -> getMothersList('','');
                $fathers_list =  $generic -> getFathersList('','');
                echo "<div class='form_container add_livestock form_hide'>";
                    echo "<h3>Add livestock</h3>";
                    echo "<form name='add_livestock' class='js_form col_3' data-action='add_livestock'>";
                            echo "<div>";
                                $form_element -> input('required', '', '', false, '', '','');
                                $form_element -> input('text', 'livestock_name', 'Name', true, 'required', 'Please enter a Name','');
                                $form_element -> input('select', 'species', 'Species', true, 'required', 'Please select a species', $species_list);
                                $form_element -> input('selectDisabled', 'breed', 'Breed', true, 'required', 'Please select a breed', $breed_list -> html);
                                $form_element -> input('text', 'uk_tag_no', 'Tag', false, '', '','');
                                $form_element -> input('textarea', 'origin', 'Origin', false, '', '','');
                            echo "</div>";
                            echo "<div>";
                                echo "<p class='form_blank'></p>";
                                $form_element -> input('date', 'date_of_birth', 'Date of birth', false, '', '','');
                                $form_element -> input('date', 'date_of_death', 'Date of death', false, '', '','');
                                $form_element -> input('date', 'date_of_sale', 'Date of sale', false, '', '','');
                                $form_element -> input('text', 'pedigree_no', 'Pedigree number', false, '', '','');
                                $form_element -> input('textarea', 'livestock_notes', 'Notes', false, '', '','');
                            echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('select', 'gender', 'Gender', true, 'required', 'Please select a gender', $gender_list);
                            $form_element -> input('selectDisabled', 'mother', 'Mother', false, '', '', $mothers_list -> html);
                            $form_element -> input('selectDisabled', 'father', 'Father', false, '', '', $fathers_list -> html);
                            $form_element -> input('checkbox', 'home_bred', 'Home bred', false, '', '','');
                            $form_element -> input('checkbox', 'for_slaughter', 'For slaughter', false, '', '','');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('submit', '', 'Add Livestock', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Edit livestock form ----------------------------------------------
            public function form_editLivestock(){
                $form_element = new FormElements();
                $generic = new Generic();
                $breed_list =  $generic -> getBreedList('','');
                $mothers_list =  $generic -> getMothersList('','');
                $fathers_list =  $generic -> getFathersList('','');
                echo "<div class='form_container edit_livestock form_hide'>";
                    echo "<h3>Edit livestock</h3>";
                    echo "<form name='edit_livestock' class='col_3 js_form' data-action='edit_livestock'>";
                            echo "<div>";
                                $form_element -> input('hidden', 'id', 'id', false, '', '','');
                                $form_element -> input('required', '', '', false, '', '','');
                                $form_element -> input('text', 'livestock_name', 'Name', true, 'required', 'Please enter a Name','');
                                $form_element -> input('select', 'species', 'Species', true, 'required', 'Please select a species', $generic -> getSpeciesList());
                                $form_element -> input('select', 'breed', 'Breed', true, 'required', 'Please select a breed', $breed_list -> html);
                                $form_element -> input('text', 'uk_tag_no', 'Tag', false, '', '','');
                                $form_element -> input('textarea', 'origin', 'Origin', false, '', '','');
                            echo "</div>";
                            echo "<div>";
                                echo "<p class='form_blank'></p>";
                                $form_element -> input('date', 'date_of_birth', 'Date of birth', false, '', '','');
                                $form_element -> input('date', 'date_of_death', 'Date of death', false, '', '','');
                                $form_element -> input('date', 'date_of_sale', 'Date of sale', false, '', '','');
                                $form_element -> input('text', 'pedigree_no', 'Pedigree number', false, '', '','');
                                $form_element -> input('textarea', 'livestock_notes', 'Notes', false, '', '','');
                            echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('select', 'gender', 'Gender', true, 'required', 'Please select a gender', $generic -> getGenderList());
                            $form_element -> input('select', 'mother', 'Mother', false, '', '', $mothers_list -> html);
                            $form_element -> input('select', 'father', 'Father', false, '', '', $fathers_list -> html);
                            $form_element -> input('checkbox', 'home_bred', 'Home bred', false, '', '','');
                            $form_element -> input('checkbox', 'for_slaughter', 'For slaughter', false, '', '','');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('submit', '', 'Edit Livestock', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add livestock ----------------------------------------------------
            public function sql_addLivestock($form_data){

                $generic = new Generic();
                $for_slaughter = $home_bred = 0;

                foreach($form_data as $value){
                    if( $value['name'] == 'species' ){ $species = $value['value']; }
                    if( $value['name'] == 'livestock_name' ){ $livestock_name = $value['value']; }
                    if( $value['name'] == 'gender' ){ $gender = $value['value']; }
                    if( $value['name'] == 'uk_tag_no' ){ $uk_tag_no = $value['value']; }
                    if( $value['name'] == 'for_slaughter' ){ $for_slaughter = $value['value']; }
                    if( $value['name'] == 'pedigree_no' ){ $pedigree_no = $value['value']; }
                    if( $value['name'] == 'date_of_birth' ){ $date_of_birth = $value['value']; }
                    if( $value['name'] == 'date_of_sale' ){ $date_of_sale = $value['value']; }
                    if( $value['name'] == 'date_of_death' ){ $date_of_death = $value['value']; }
                    if( $value['name'] == 'mother' ){ $mother = $value['value']; }
                    if( $value['name'] == 'father' ){ $father = $value['value']; }
                    if( $value['name'] == 'home_bred' ){ $home_bred = $value['value']; }
                    if( $value['name'] == 'origin' ){ $origin = $value['value']; }
                    if( $value['name'] == 'breed' ){ $breed = $value['value']; }
                    if( $value['name'] == 'livestock_notes' ){ $livestock_notes = $value['value']; }
                };

                $date_of_birth = $date_of_birth == null ? null : $date_of_birth;
                $date_of_sale = $date_of_sale == null ? null : $date_of_sale;
                $date_of_death = $date_of_death == null ? null : $date_of_death;

                $this -> connect();
                    $query = "INSERT INTO livestock (species, livestock_name, gender, uk_tag_no,
                                                     for_slaughter, pedigree_no, date_of_birth,
                                                     date_of_sale, date_of_death, mother,
                                                     father, home_bred, origin, breed, notes)
                              VALUES ( :species, :livestock_name, :gender, :uk_tag_no,
                                       :for_slaughter, :pedigree_no, :date_of_birth,
                                       :date_of_sale, :date_of_death, :mother,
                                       :father, :home_bred, :origin, :breed, :notes)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':livestock_name', $livestock_name);
                    $sql -> bindParam(':gender', $gender);
                    $sql -> bindParam(':uk_tag_no', $uk_tag_no);
                    $sql -> bindParam(':for_slaughter', $for_slaughter);
                    $sql -> bindParam(':pedigree_no', $pedigree_no);
                    $sql -> bindParam(':date_of_birth', $date_of_birth);
                    $sql -> bindParam(':date_of_sale', $date_of_sale);
                    $sql -> bindParam(':date_of_death', $date_of_death);
                    $sql -> bindParam(':mother', $mother);
                    $sql -> bindParam(':father', $father);
                    $sql -> bindParam(':home_bred', $home_bred);
                    $sql -> bindParam(':origin', $origin);
                    $sql -> bindParam(':breed', $breed);
                    $sql -> bindParam(':notes', $livestock_notes);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                $output -> action = 'livestockAdded';
                $output -> uk_tag_no = $uk_tag_no;
                $output -> livestock_name = $livestock_name;
                $output -> date_of_birth = $date_of_birth;
                $output -> species = $generic -> getSpecies($species);
                $output -> breed = $generic -> getBreed($breed);
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Edit livestock ---------------------------------------------------
            public function sql_editLivestock($form_data){

                $generic = new Generic();
                $for_slaughter = $home_bred = 0;

                foreach($form_data as $value){
                    if( $value['name'] == 'id' ){ $id = $value['value']; }
                    if( $value['name'] == 'species' ){ $species = $value['value']; }
                    if( $value['name'] == 'livestock_name' ){ $livestock_name = $value['value']; }
                    if( $value['name'] == 'gender' ){ $gender = $value['value']; }
                    if( $value['name'] == 'uk_tag_no' ){ $uk_tag_no = $value['value']; }
                    if( $value['name'] == 'for_slaughter' ){ $for_slaughter = $value['value']; }
                    if( $value['name'] == 'pedigree_no' ){ $pedigree_no = $value['value']; }
                    if( $value['name'] == 'date_of_birth' ){ $date_of_birth = $value['value']; }
                    if( $value['name'] == 'date_of_sale' ){ $date_of_sale = $value['value']; }
                    if( $value['name'] == 'date_of_death' ){ $date_of_death = $value['value']; }
                    if( $value['name'] == 'mother' ){ $mother = $value['value']; }
                    if( $value['name'] == 'father' ){ $father = $value['value']; }
                    if( $value['name'] == 'home_bred' ){ $home_bred = $value['value']; }
                    if( $value['name'] == 'origin' ){ $origin = $value['value']; }
                    if( $value['name'] == 'breed' ){ $breed = $value['value']; }
                    if( $value['name'] == 'livestock_notes' ){ $livestock_notes = $value['value']; }
                };

                // -- Get existing TAG details ---------------------------------
                    $this -> connect();
                        $query = "SELECT uk_tag_no, previous_tags FROM livestock WHERE id = :id";
                        $sql = self::$conn -> prepare($query);
                        $sql -> bindParam(':id', $id);
                        $sql -> execute();
                        $row = $sql -> fetch();
                    $this -> disconnect();
                    if( $row['previous_tags'] == null && $row['uk_tag_no'] == null ){
                        $previous_tags = null;
                    }else{
                        $existing_tag = $row['uk_tag_no'];
                        if($row['previous_tags'] != null){
                            $previous_tags = explode("[[~]]", $row['previous_tags']);
                        }else{
                            $previous_tags = array();
                        }
                        array_push($previous_tags, $existing_tag);
                        $previous_tags = implode("[[~]]", $previous_tags);
                    }
                // -------------------------------------------------------------

                $this -> connect();
                    $query = "  UPDATE livestock
                                SET species = :species,
                                    livestock_name = :livestock_name,
                                    gender = :gender,
                                    uk_tag_no = :uk_tag_no,
                                    previous_tags = :previous_tags,
                                    for_slaughter = :for_slaughter,
                                    pedigree_no = :pedigree_no,
                                    date_of_birth = :date_of_birth,
                                    date_of_sale = :date_of_sale,
                                    date_of_death = :date_of_death,
                                    mother = :mother,
                                    father = :father,
                                    home_bred = :home_bred,
                                    origin = :origin,
                                    breed = :breed,
                                    notes = :notes
                                WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':species', $species);
                    $sql -> bindParam(':livestock_name', $livestock_name);
                    $sql -> bindParam(':gender', $gender);
                    $sql -> bindParam(':uk_tag_no', $uk_tag_no);
                    $sql -> bindParam(':previous_tags', $previous_tags);
                    $sql -> bindParam(':for_slaughter', $for_slaughter);
                    $sql -> bindParam(':pedigree_no', $pedigree_no);
                    $sql -> bindParam(':date_of_birth', $date_of_birth);
                    $sql -> bindParam(':date_of_sale', $date_of_sale);
                    $sql -> bindParam(':date_of_death', $date_of_death);
                    $sql -> bindParam(':mother', $mother);
                    $sql -> bindParam(':father', $father);
                    $sql -> bindParam(':home_bred', $home_bred);
                    $sql -> bindParam(':origin', $origin);
                    $sql -> bindParam(':breed', $breed);
                    $sql -> bindParam(':notes', $livestock_notes);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                $output -> action = 'livestockEdited';
                $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Delete livestock -------------------------------------------------
            public function sql_deleteLivestock($form_data, $site_data){
                $id = $form_data[0]['value'];
                $this -> connect();
                    $query = "DELETE FROM livestock WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'livestockDeleted';
                $output -> id = $id;
                $output -> site_root = $site_data['site_root'];
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

    }

?>
