<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $feed = new Feed();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $feed -> feedCard($site_data, $_GET['id'], 'echo');
            $feed -> form_editFeed();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_feed'>Add feed</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Current feed</h2>";
                echo $feed -> currentFeedCard($site_data);
            echo "</div>";
            echo "<div class='card'>";
                echo "<h2>Finished feed</h2>";
                $years =  $feed -> getFeedYears();
                foreach ($years as $year) {
                    echo "<details>";
                    echo "<summary>$year</summary>";
                    echo $feed -> finishedFeedCard($site_data, $year);
                    echo "</details>";
                }
            echo "</div>";
            $feed -> form_addFeed();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
