<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $reminders = new Reminders();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $reminders -> singleReminder($site_data, $_GET['id'], 'echo');
            $reminders -> form_editReminder();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_reminder'>Add reminder</a>";
            echo "</p>";
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
                echo "<h3>Completed</h3>";
                echo $reminders -> remindersCard($site_data, 'completed');
            echo "</div>";
            $reminders -> form_addReminder();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
