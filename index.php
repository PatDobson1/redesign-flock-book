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
        $breeds = new Breeds();
        $reminders = new Reminders();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        echo "<div class='col_2'>";
            echo "<div class='card'>";
                echo "<h2>Species</h2>";
                $species -> speciesCard(false);
            echo "</div>";
            echo "<div class='card'>";
                echo "<h2>Breeds</h2>";
                $breeds-> simpleBreedCard(false);
            echo "</div>";
        echo "</div>";
        echo "<div class='card'>";
            echo "<h2>Reminders</h2>";
            echo "<h3>Overdue</h3>";
            echo $reminders -> remindersCard($site_data, 'overdue');
            echo "<h3>Today</h3>";
            echo $reminders -> remindersCard($site_data, 'today');
            echo "<h3>Future</h3>";
            echo $reminders -> remindersCard($site_data, 'future');
            echo "<h3>Un-dated</h3>";
            echo $reminders -> remindersCard($site_data, 'noDate');
        echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
