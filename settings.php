<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $settings = new Settings();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        echo "<div class='card'>";
            echo "<h2>Settings</h2>";
            echo "<a class='js_showForm js_dontHide btn_island' data-form='change_password'>Change password</a>";
        echo "</div>";
        $settings -> form_changePassword();

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
