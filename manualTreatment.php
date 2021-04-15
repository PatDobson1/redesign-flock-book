<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $manualTreatment = new ManualTreatment();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $manualTreatment -> manualTreatmentCardSingle($site_data, $_GET['id'], 'echo');
            $manualTreatment -> form_editManualTreatment();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_manualTreatment'>Add manual treatment</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Manual treatment</h2>";
                echo $manualTreatment -> manualTreatmentCard($site_data);
            echo "</div>";
            $manualTreatment -> form_addManualTreatment();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
