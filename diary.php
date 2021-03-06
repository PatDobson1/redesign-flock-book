<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $diary = new Diary();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $diary -> singleDiaryEntry($site_data, $_GET['id'], 'echo');
            $diary -> form_editDiary();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_diary'>Add diary entry</a>";
            echo "</p>";
            echo "<div class='card diaryCard'>";
                echo "<h2>Diary</h2>";
                $years =  $diary -> getDiaryYears();
                $thisYear = Date('Y');
                foreach ($years as $year) {
                    echo "<div class='accordion'>";
                        echo "<p class='accordion_title'><span></span>$year</p>";
                        echo "<div class='accordion_contents'>";
                            echo $diary -> fullDiary($site_data, $year);
                        echo "</div>";
                    echo "</div>";
                }
            echo "</div>";
            $diary -> addDiaryEntry();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
