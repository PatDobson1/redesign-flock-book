<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        $livestock = new Livestock();
        echo "<div class='col_2'>";
            echo "<div class='temp'>";
                echo "<h2>Species</h2>";
                $livestock -> getSpecies();
            echo "</div>";
            echo "<div class='temp'>";
                echo "<h2>Livestock count</h2>";
                echo "<p>All :: " . $livestock -> countLivestock('all') . "</p>";
                echo "<p>Alive :: " . $livestock -> countLivestock('alive') . "</p>";
                echo "<p>Females :: " . $livestock -> countLivestock('female') . "</p>";
                echo "<p>Males :: " . $livestock -> countLivestock('male') . "</p>";
            echo "</div>";
        echo "</div>";
        echo "<div class='temp'>";
            $livestock -> getAllLivestock();
        echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
