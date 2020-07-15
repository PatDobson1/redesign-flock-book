<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        $sheep = new Sheep();
        echo "<p>All :: " . $sheep -> countSheep('all') . "</p>";
        echo "<p>Alive :: " . $sheep -> countSheep('alive') . "</p>";
        echo "<p>Ewes :: " . $sheep -> countSheep('female') . "</p>";
        echo "<p>Rams :: " . $sheep -> countSheep('male') . "</p>";
        $sheep -> getAllSheep();

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
