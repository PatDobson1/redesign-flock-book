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

        echo "<div class='card'>";
            echo "<h2>Breeds</h2>";
            $breeds-> breedCard(true);
        echo "</div>";
        echo "<p>";
            echo "<a class='js_showForm btn_island' data-form='add_breed'>Add breed</a>";
        echo "</p>";
        $breeds -> form_addBreed();
        $breeds -> form_editBreed();

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
