<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        $livestock = new Livestock();
            echo "<div class='card'>";
                echo "<h2>Breeds</h2>";
                $livestock -> breedCard();
            echo "</div>";
            echo "<div class='card'>";
                echo "<h2>Species</h2>";
                $livestock -> speciesCard();
            echo "</div>";
            echo "<div class='card'>";
                $livestock -> getAllLivestock();
            echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
