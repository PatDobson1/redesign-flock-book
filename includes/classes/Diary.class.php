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


                    // $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock'], $site_data);
                    // $medicine = explode(',', $row['medicine']);
                    // $medicine_length = $row['medicine'] ? count($medicine) : 0;

                    echo "<div class='diaryEntry js-view' data-id='$row[id]'>";
                        $entry_date = $functions -> cardDateFormat($row['entry_date']);
                        echo "<span>$entry_date</span>";
                        echo "<span>$row[notes]</span>";
                        echo "<a class='icon icon_quickView js-diaryQuickView' data-id='$row[id]'></a>";
                        // echo "<details>";
                        //     echo "<summary>Livestock</summary>";
                        //     echo $livestock_details;
                        // echo "</details>";
                        // echo "<details>";
                        //     echo "<summary>Medicine</summary><ul>";
                        //     foreach($medicine as $item){
                        //         $medicine_detail = $medicine_class -> getMedicine($item);
                        //         $medicine_description = $medicine_detail['description'] ? ($medicine_detail[description]) : '';
                        //         echo "<li>$medicine_detail[medicine_name] $medicine_description</li>";
                        //     };
                        // echo "</li></details>";
                        // echo "<details>";
                        //     echo "<summary>Manual treatment</summary>";
                        //     echo "<p>$row[manual_treatment]</p>";
                        // echo "</details>";
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

                $data = '';
                $data .= "<div class='card diaryCardSingle'>";
                    $data .= "<h2>Diary</h2>";
                    $data .= "<span>$entry_date</span>";
                    $data .= "<p class='diaryNotes'>$row[notes]</p>";
                    $data .= "<p>Medicine : $row[medicine]</p>";
                    $data .= "<p>Manual treatment : $row[manual_treatment]</p>";
                    $data .= "<p>Livestock : $row[livestock]</p>";
                $data .= "</div>";

                if($context == 'echo'){
                    echo $data;
                }else{
                    return $data;
                }

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
                        $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock'], $site_data);

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
