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
        // echo "<div class='col_2'>";
            echo "<div class='card reminders_card'>";
                $overdueCount = $reminders -> remindersCount('overdue');
                $todayCount = $reminders -> remindersCount('today');
                $futureCount = $reminders -> remindersCount('future');
                $noDateCount = $reminders -> remindersCount('noDate');
                $completedCount = $reminders -> remindersCount('completed');
                echo "<h2>Reminders</h2>";
                if($overdueCount){
                    echo "<h3>Overdue</h3>";
                    echo $reminders -> remindersCard($site_data, 'overdue');
                }
                if($todayCount){
                    echo "<h3>Today</h3>";
                    echo $reminders -> remindersCard($site_data, 'today');
                }
                if($futureCount){
                    echo "<h3>Future</h3>";
                    echo $reminders -> remindersCard($site_data, 'future');
                }
                if($noDateCount){
                    echo "<h3>Un-dated</h3>";
                    echo $reminders -> remindersCard($site_data, 'noDate');
                }
            echo "</div>";
        // echo "</div>";

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
