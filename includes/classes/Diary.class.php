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
                $data .= "<div class='card diaryCardSingle'>";
                    $data .= "<h2>Diary</h2>";
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
                                        $data .= "<li><a href='$site_data[site_root]/manualTreatment?id=$medicine_detail[id]'>$manual_treatment_detail[treatment_name]</a></li>";
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
                echo "<div class='form_container add_diary form_hide'>";
                    echo "<h3>Add diary entry</h3>";
                    echo "<form name='add_diary' class='col_2 js_form' data-action='add_diary'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('date', 'entry_date', 'Date', true, 'required', 'Please enter a Date','');
                            $form_element -> input('hidden', 'entry_added_date', '', 'false', '', '', '');
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '','');
                            $form_element -> multiselect();
                            $form_element -> input('submit', '', 'Add Diary entry', false, '', '','');
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

    }

?>
