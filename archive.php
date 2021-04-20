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

        $soldYears = $livestock -> getDiaryYears('sold');
        $deadYears = $livestock -> getDiaryYears('dead');
        echo "<div class='card'>";
            echo "<h2>Archive - sold</h2>";
            foreach ($soldYears as $soldYear) {
                echo "<details>";
                echo "<summary>$soldYear</summary>";
                echo $livestock-> liveStockArchiveCard(true, 'sold', $soldYear, $site_data);
                echo "</details>";
            }
        echo "</div>";
        echo "<div class='card'>";
            echo "<h3>Archive - dead</h3>";
            foreach ($deadYears as $deadYear) {
                echo "<details>";
                echo "<summary>$deadYear</summary>";
                echo $livestock-> liveStockArchiveCard(true, 'dead', $deadYear, $site_data);
                echo "</details>";
            }
        echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
