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

        echo "<div class='col_2'>";
            echo "<div class='card'>";
                echo "<h2>Species</h2>";
                $species -> speciesCard(false);
            echo "</div>";
            echo "<div class='card'>";
                echo "<h2>Reminders</h2>";
            echo "</div>";
        echo "</div>";
        echo "<div class='card'>";
            echo "<h2>Breeds</h2>";
            $livestock -> getAllLivestock();
        echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
