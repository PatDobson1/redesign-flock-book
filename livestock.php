<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $livestock = new Livestock();
        $species = new Species();
        $breeds = new Breeds();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $livestock -> animalCard($site_data, $_GET['id']);
            $livestock -> siblingsCard($site_data, $_GET['id']);
            $livestock -> childrenCard($site_data, $_GET['id']);
            $livestock -> familyTree($site_data, $_GET['id']);
            $livestock -> diaryCard($site_data, $_GET['id']);
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_livestock'>Add livestock</a>";
            echo "</p>";
            $livestock -> animalSearchCard($site_data);
            echo "<div class='card'>";
                echo "<h2>Livestock</h2>";
                $livestock -> liveStockCard(true);
            echo "</div>";
            $livestock -> form_addLivestock();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
