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
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        echo "<div class='card'>";
            echo "<h2>Species</h2>";
            $livestock -> speciesCard();
        echo "</div>";
        echo "<p>";
            echo "<a class='js_showForm btn_island' data-form='add_species'>Add species</a>";
        echo "</p>";
        $species -> form_addSpecies();

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
