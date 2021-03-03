<?php

    class Diary extends Db{

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
                        $livestock_details = $livestock_class -> sql_getLivestockRange($row['livestock']);

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

    }

?>
