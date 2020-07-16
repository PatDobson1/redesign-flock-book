<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        $livestock = new Livestock();
        echo "<p>All :: " . $livestock -> countLivestock('all') . "</p>";
        echo "<p>Alive :: " . $livestock -> countLivestock('alive') . "</p>";
        echo "<p>Females :: " . $livestock -> countLivestock('female') . "</p>";
        echo "<p>Males :: " . $livestock -> countLivestock('male') . "</p>";
        $livestock -> getAllLivestock();

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
