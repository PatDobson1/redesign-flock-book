<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $breeds = new Breeds();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $breeds -> singleBreedCard($site_data, $_GET['id'], 'echo');
            $breeds -> form_editBreed();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_breed'>Add breed</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Breeds</h2>";
                $breeds-> breedCard(true);
            echo "</div>";
            $breeds -> form_addBreed();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
