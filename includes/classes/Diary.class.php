<?php

    class Diary extends Db{

        // -- Full Diary -------------------------------------------------------
            public function fullDiary($site_data, $year){

                $functions = new Functions();

                $medicine_class = new Medicine();
                $manual_treatment_class = new ManualTreatment();
                $livestock_class = new Livestock();

                $query = "SELECT *
                          FROM livestock_diary
                          WHERE YEAR(entry_date) = :year
                          ORDER BY entry_date DESC";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':year', $year);
                    $sql -> execute();
                $this -> disconnect();

                while( $row = $sql -> fetch() ){

                    echo "<div class='diaryEntry js-view' data-id='$row[id]'>";
                        $entry_date = $functions -> cardDateFormat($row['entry_date']);
                        echo "<span>$entry_date</span>";
                        echo "<span>$row[notes]</span>";
                        echo "<a class='icon icon_quickView js-diaryQuickView' data-id='$row[id]'></a>";
                    echo "</div>";

                }

            }

        // ---------------------------------------------------------------------

        // -- Single diary entry -----------------------------------------------
            public function singleDiaryEntry($site_data, $id, $context){

                $functions = new Functions();

                $medicine_class = new Medicine();
                $manual_treatment_class = new ManualTreatment();
                $livestock_class = new Livestock();

                $query = "SELECT * FROM livestock_diary WHERE id = :id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $entry_date = $functions -> cardDateFormat($row['entry_date']);
                $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock'], $site_data, 'complex');
                $medicine = explode(',', $row['medicine']);
                $medicine_length = $row['medicine'] ? count($medicine) : 0;
                $manual_treatment = explode(',',$row['manual_treatment']);
                $manual_treatment_length = $row['manual_treatment'] ? count($manual_treatment) : 0;

                $data = '';
                $data.= "<p class='controls'>";
                    $data.= "<a href='$site_data[site_root]/diary' class='back'>Back to diary</a>";
                    $data.= "<a class='right_aligned js_edit_btn' data-editid='$row[id]' data-edittype='diary' data-form='edit_diary'>Edit diary entry</a>";
                $data.= "</p>";
                $data .= "<div class='card diaryCardSingle'>";
                    $data .= "<h2>Diary entry</h2>";
                    $data .= "<span>$entry_date</span>";
                    $data .= "<p class='diaryNotes'>$row[notes]</p>";
                    // -- Medicine ---------------------------------------------
                        if($medicine_length){
                            $data .= "<section>";
                                $data .= "<h3>Medicine</h3>";
                                $data .=  "<ul>";
                                    foreach($medicine as $item){
                                        $medicine_detail = $medicine_class -> getMedicine($item);
                                        $medicine_description = $medicine_detail['description'] ? ($medicine_detail['description']) : '';
                                        $data .= "<li><a href='$site_data[site_root]/medicine?id=$medicine_detail[id]'>$medicine_detail[medicine_name] $medicine_description</a></li>";
                                    };
                                $data .= "</ul>";
                            $data .= "</section>";
                        }
                    // ---------------------------------------------------------
                    // -- Manual treatment -------------------------------------
                        if($manual_treatment_length){
                            $data .= "<section>";
                                $data .= "<h3>Manual treatment</h3>";
                                $data .= "<ul>";
                                    foreach($manual_treatment as $item){
                                        $manual_treatment_detail = $manual_treatment_class -> getManualTreatment($item);
                                        $data .= "<li><a href='$site_data[site_root]/manualTreatment?id=$manual_treatment_detail[id]'>$manual_treatment_detail[treatment_name]</a></li>";
                                    }
                                $data .= "</ul>";
                            $data .= "</section>";
                        }
                    // ---------------------------------------------------------
                    // -- Livestock --------------------------------------------
                        $data .= "<section class='livestock_details'>";
                            $data .= "<h3>Livestock</h3>";
                            $data .=  $livestock_details;
                        $data .= "</section>";
                    // ---------------------------------------------------------
                $data .= "</div>";

                if($context == 'echo'){
                    echo $data;
                }else{
                    return $data;
                }

            }
        // ---------------------------------------------------------------------

        // -- Quick diary view -------------------------------------------------
            public function diaryQuickView($site_data, $id){

                $functions = new Functions();

                $medicine_class = new Medicine();
                $manual_treatment_class = new ManualTreatment();
                $livestock_class = new Livestock();

                $query = "SELECT * FROM livestock_diary WHERE id = :id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $entry_date = $functions -> cardDateFormat($row['entry_date']);
                $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock'], $site_data, 'simple');
                $medicine = explode(',', $row['medicine']);
                $medicine_length = $row['medicine'] ? count($medicine) : 0;
                $manual_treatment = explode(',',$row['manual_treatment']);
                $manual_treatment_length = $row['manual_treatment'] ? count($manual_treatment) : 0;

                $data = '';
                $data .= "<span>$entry_date</span>";
                $data .= "<p class='diaryNotes'>$row[notes]</p>";
                // -- Medicine ---------------------------------------------
                    if($medicine_length){
                        $data .= "<section>";
                            $data .= "<h3>Medicine</h3>";
                            $data .=  "<ul>";
                                foreach($medicine as $item){
                                    $medicine_detail = $medicine_class -> getMedicine($item);
                                    $medicine_description = $medicine_detail['description'] ? ($medicine_detail['description']) : '';
                                    $data .= "<li>$medicine_detail[medicine_name] $medicine_description</li>";
                                };
                            $data .= "</ul>";
                        $data .= "</section>";
                    }
                // ---------------------------------------------------------
                // -- Manual treatment -------------------------------------
                    if($manual_treatment_length){
                        $data .= "<section>";
                            $data .= "<h3>Manual treatment</h3>";
                            $data .= "<ul>";
                                foreach($manual_treatment as $item){
                                    $manual_treatment_detail = $manual_treatment_class -> getManualTreatment($item);
                                    $data .= "<li>$manual_treatment_detail[treatment_name]</li>";
                                }
                            $data .= "</ul>";
                        $data .= "</section>";
                    }
                // ---------------------------------------------------------
                // -- Livestock --------------------------------------------
                    $data .= "<section class='livestock_details'>";
                        $data .= "<h3>Livestock</h3>";
                        $data .= "<ul>";
                            $data .=  $livestock_details;
                        $data .= "</ul>";
                    $data .= "</section>";
                // ---------------------------------------------------------

                echo $data;

            }
        // ---------------------------------------------------------------------

        // -- Diary card -------------------------------------------------------
            public function diaryCard($site_data, $id){

                $medicine_class = new Medicine();
                $manual_treatment_class = new ManualTreatment();
                $livestock_class = new Livestock();

                $query = "SELECT * FROM livestock_diary ORDER BY entry_added_date DESC";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                $this -> disconnect();

                echo "<div class='card'>";
                echo "  <h2>Diary</h2>";
                while( $row = $sql -> fetch() ){
                    $livestock = explode(',', $row['livestock']);
                    if( in_array($id, $livestock) ){

                        $medicine = explode(',', $row['medicine']);
                        $medicine_length = $row['medicine'] ? count($medicine) : 0;
                        $manual_treatment = explode(',', $row['manual_treatment']);
                        $manual_treatment_length = $row['manual_treatment'] ? count($manual_treatment) : 0;
                        $livestock_length = count($livestock);
                        $date = date_create($row['entry_added_date']);
                        $display_date = date_format($date, 'j F Y');
                        $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock'], $site_data, 'complex');

                        echo "<div class='diaryCard'>";
                            echo "<h3>$display_date</h3>";
                            echo "<p>$row[notes]</p>";
                            if( $medicine_length ){
                                echo "<details><summary>Medicines</summary><ul>";
                                foreach($medicine as $item){
                                    $medicine_detail = $medicine_class -> getMedicine($item);
                                    echo "  <li>$medicine_detail[medicine_name] ($medicine_detail[description])</li>";
                                }
                                echo "</ul></details>";
                            }
                            if( $manual_treatment_length ){
                                echo "<details><summary>Manual treatments</summary><ul>";
                                foreach ($manual_treatment as $item) {
                                    $manual_treatment_detail = $manual_treatment_class -> getManualTreatment($item);
                                    echo "<li>$manual_treatment_detail[treatment_name]</li>";
                                }
                                echo "</ul></details>";
                            }
                            if( $livestock_length > 1 ){
                                echo "<p><details><summary>Livestock</summary>";
                                echo $livestock_details;
                                echo "</details></p>";
                            }
                        echo "</div>";
                    }
                }
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add diary entry --------------------------------------------------
            public function addDiaryEntry(){

                $form_element = new FormElements();
                $generic = new Generic();
                echo "<div class='form_container add_diary form_hide'>";
                    echo "<h3>Add diary entry</h3>";
                    echo "<form name='add_diary' class='col_2 js_form' data-action='add_diary'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('date', 'entry_date', 'Date', true, 'required', 'Please enter a Date','');
                            $form_element -> input('selectMulti', 'medicine', 'Medicine', false, '', '', $generic -> getMedicineList());
                            $form_element -> input('selectMulti', 'manual_treatment', 'Manual treatment', false, '', '', $generic -> getManualTreatmentList());
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> multiselect();
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '','');
                            $form_element -> input('submit', '', 'Add diary entry', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";

            }
        // ---------------------------------------------------------------------

        // -- Edit diary entry -------------------------------------------------
            public function form_editDiary(){

                $form_element = new FormElements();
                $generic = new Generic();
                echo "<div class='form_container edit_diary form_hide'>";
                    echo "<h3>Edit diary entry</h3>";
                    echo "<form name='edit_diary' class='col_2 js_form' data-action='edit_diary'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('date', 'entry_date', 'Date', true, 'required', 'Please enter a Date','');
                            $form_element -> input('selectMulti', 'medicine', 'Medicine', false, '', '', $generic -> getMedicineList());
                            $form_element -> input('selectMulti', 'manual_treatment', 'Manual treatment', false, '', '', $generic -> getManualTreatmentList());
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> multiselect();
                            $form_element -> input('hidden', 'id', '', 'false', '', '', '');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '','');
                            $form_element -> input('submit', '', 'Edit diary entry', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";

            }
        // ---------------------------------------------------------------------

        // -- Diary years ------------------------------------------------------
            public function getDiaryYears(){

                $this -> connect();

                    $query = "SELECT DISTINCT YEAR(entry_date) AS year
                              FROM livestock_diary
                              ORDER BY entry_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    $years = array();
                    while( $row = $sql -> fetch() ){
                        array_push($years, $row['year']);
                    }
                    return $years;

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Add diary entry --------------------------------------------------
            public function sql_addDiary($form_data){

                $medicine = [];
                $manual_treatment = [];
                $livestock = [];
                foreach($form_data as $value){
                    if( $value['name'] == 'entry_date' ){ $entry_date = $value['value']; }
                    if( $value['name'] == 'notes' ){ $notes = $value['value']; }
                    if( $value['name'] == 'medicine' ){ array_push($medicine, $value['value']); }
                    if( $value['name'] == 'manual_treatment' ){ array_push($manual_treatment, $value['value']); }
                    if( $value['name'] == 'livestockSelected[]' ){ array_push($livestock, $value['value']); }
                };
                $medicine = implode(",", $medicine);
                $manual_treatment = implode(",", $manual_treatment);
                $livestock = implode(",", $livestock);

                $this -> connect();
                    $query = "INSERT INTO livestock_diary (entry_date, entry_added_date, notes, livestock, medicine, manual_treatment)
                              VALUES (:entry_date, now(), :notes, :livestock, :medicine, :manual_treatment)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':entry_date', $entry_date);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> bindParam(':livestock', $livestock);
                    $sql -> bindParam(':medicine', $medicine);
                    $sql -> bindParam(':manual_treatment', $manual_treatment);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'diaryAdded';
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Edit diary entry -------------------------------------------------
            public function sql_editDiary($form_data){

                $medicine = [];
                $manual_treatment = [];
                $livestock = [];
                foreach($form_data as $value){
                    if( $value['name'] == 'id' ){ $id = $value['value']; }
                    if( $value['name'] == 'entry_date' ){ $entry_date = $value['value']; }
                    if( $value['name'] == 'notes' ){ $notes = $value['value']; }
                    if( $value['name'] == 'medicine' ){ array_push($medicine, $value['value']); }
                    if( $value['name'] == 'manual_treatment' ){ array_push($manual_treatment, $value['value']); }
                    if( $value['name'] == 'livestockSelected[]' ){ array_push($livestock, $value['value']); }
                };
                $medicine = implode(",", $medicine);
                $manual_treatment = implode(",", $manual_treatment);
                $livestock = implode(",", $livestock);

                $this -> connect();
                    $query = "  UPDATE livestock_diary
                                SET entry_date = :entry_date,
                                    notes = :notes,
                                    livestock = :livestock,
                                    medicine = :medicine,
                                    manual_treatment = :manual_treatment
                                WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':entry_date', $entry_date);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> bindParam(':livestock', $livestock);
                    $sql -> bindParam(':medicine', $medicine);
                    $sql -> bindParam(':manual_treatment', $manual_treatment);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                $output -> action = 'diaryEdited';
                $output -> id = $id;
                $output -> entry_date = $entry_date;
                $output -> notes = $notes;
                $output -> medicine = $medicine;
                $output -> manual_treatment = $manual_treatment;
                $output -> livestock = $livestock;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Get medicine -----------------------------------------------------
            public function sql_getDiary($id){

                $this -> connect();

                    $query = "SELECT * FROM livestock_diary WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $output = new stdClass();
                    if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output -> id = $id;
                        $output -> entry_date = $row['entry_date'];
                        $output -> notes = $row['notes'];
                        $output -> livestock = $row['livestock'];
                        $output -> medicine = $row['medicine'];
                        $output -> manual_treatment = $row['manual_treatment'];
                    }
                    echo json_encode($output);

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

    }

?>
