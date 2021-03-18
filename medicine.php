<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $medicine = new Medicine();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $medicine -> medicineCard($site_data, $_GET['id'], 'echo');
            $medicine -> form_editMedicine();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_medicine'>Add medicine</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Current medicine</h2>";
                echo $medicine -> currentMedicineCard($site_data);
            echo "</div>";
            echo "<div class='card'>";
                echo "<h2>Finished medicine</h2>";
                $years =  $medicine -> getMedicineYears();
                foreach ($years as $year) {
                    echo "<details>";
                    echo "<summary>$year</summary>";
                    echo $medicine -> finishedMedicineCard($year);
                    echo "</details>";
                }
            echo "</div>";
            $medicine -> form_addMedicine();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
