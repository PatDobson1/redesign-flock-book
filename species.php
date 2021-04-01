<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $species = new Species();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $species -> singleSpeciesCard($site_data, $_GET['id'], 'echo');
            $species -> form_editSpecies();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_species'>Add species</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Species</h2>";
                $species-> speciesCard(true);
            echo "</div>";
            $species -> form_addSpecies();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
