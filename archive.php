<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $livestock = new Livestock();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        echo "<div class='card'>";
            echo "<h2>Archive - sold</h2>";
            $livestock-> liveStockArchiveCard(true, 'sold', $site_data);
        echo "</div>";
        echo "<div class='card'>";
            echo "<h3>Archive - dead</h3>";
            $livestock-> liveStockArchiveCard(true, 'dead', $site_data);
        echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
