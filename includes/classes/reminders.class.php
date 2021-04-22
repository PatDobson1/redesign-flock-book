<?php

    class Reminders extends Db{

        // -- Reminders card ----------------------------------------------------
            public function remindersCard($edit, $context){
                $this -> connect();
                    switch( $context ){
                        case 'overdue':
                            $query = "SELECT * FROM reminders
                                      WHERE reminder_date < CURRENT_DATE() AND completed != 1
                                      ORDER by reminder_date ASC";
                        break;
                        case 'today':
                            $query = "SELECT * FROM reminders
                                      WHERE reminder_date = CURRENT_DATE() AND completed != 1
                                      ORDER by reminder_date ASC";
                        break;
                        case 'future':
                            $query = "SELECT * FROM reminders
                                      WHERE reminder_date > CURRENT_DATE() AND completed != 1
                                      ORDER by reminder_date ASC";
                        break;
                        case 'noDate':
                            $query = "SELECT * FROM reminders
                                      WHERE reminder_date IS null AND completed != 1
                                      ORDER by reminder_date ASC";
                        break;
                        case 'completed':
                            $query = "SELECT * FROM reminders
                                      WHERE completed = 1
                                      ORDER by reminder_date ASC";
                        break;
                    }
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table class='reminder_table'>
                                <tr>
                                    <th>Due date</th>
                                    <th width='100px'>Priority</th>
                                    <th>Description</th>
                                </tr>";
                                    while( $row = $sql -> fetch() ){
                                        switch(true){
                                            case $row['priority'] > 3:
                                                $colour = 'red';
                                            break;
                                            case $row['priority'] == 3:
                                                $colour = 'amber';
                                            break;
                                            case $row['priority'] > 0 && $row['priority'] < 3:
                                                $colour = 'green';
                                            break;
                                        }
                                        $priority = "<p class='priority $colour'>";
                                        for( $i=0; $i<5; $i++ ){
                                            $display = $i + 1;
                                            if( $row['priority'] > $i ){
                                                $priority .= "<span>$display</span>";
                                            }else{
                                                $priority .= "<span class='blank'></span>";
                                            }
                                        }
                                        $priority .= "</p>";
                                        $description = nl2br($row['description']);
                                        $data_tag = $edit ? "data-id = '$row[id]' class='js-view'" : '';
                                        echo " <tr $data_tag>
                                                    <td class='cen'>$row[reminder_date]</td>
                                                    <td class='left'>$priority</td>
                                                    <td class='left'>$description</td>
                                                </tr>";
                                    }
                    echo "  </table>";
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get reminder numbers ---------------------------------------------
            public function remindersCount($context){
                $this -> connect();
                    switch( $context ){
                        case 'overdue':
                            $query = "SELECT COUNT(id) AS reminderCount FROM reminders
                                      WHERE reminder_date < CURRENT_DATE() AND completed != 1";
                        break;
                        case 'today':
                            $query = "SELECT COUNT(id) AS reminderCount FROM reminders
                                      WHERE reminder_date = CURRENT_DATE() AND completed != 1";
                        break;
                        case 'future':
                            $query = "SELECT COUNT(id) AS reminderCount FROM reminders
                                      WHERE reminder_date > CURRENT_DATE() AND completed != 1";
                        break;
                        case 'noDate':
                            $query = "SELECT COUNT(id) AS reminderCount FROM reminders
                                      WHERE reminder_date IS null AND completed != 1";
                        break;
                        case 'completed':
                            $query = "SELECT COUNT(id) AS reminderCount FROM reminders
                                      WHERE completed = 1";
                        break;
                    }
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['reminderCount'];
                $this -> disconnect();

            }

        // ---------------------------------------------------------------------

        // -- Single reminder --------------------------------------------------
            public function singleReminder($site_data, $id, $return){
                echo "S IN G L E  R E M I N D E R";
            }
        // ---------------------------------------------------------------------

        // -- Add reminder form ------------------------------------------------
            public function form_addReminder(){
                $generic = new Generic();
                $form_element = new FormElements();
                $priorityList = "<option value='1' selected>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>";
                echo "<div class='form_container add_reminder form_hide'>";
                    echo "<h3>Add reminder</h3>";
                    echo "<form name='add_reminder' class='col_2 js_form' data-action='add_reminder'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('date', 'reminder_date', 'Due date (leave blank for non-dated reminder)', false, '', '','');
                            $form_element -> input('textarea', 'description', 'Notes', true, 'required', 'Please enter some notes', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('select', 'priority', 'Priority (5 is highest)', false, '', '',$priorityList);
                            $form_element -> input('textarea', 'emails', 'Email recipients (separate with comma)', false, '', '','');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('submit', '', 'Add reminder', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add reminder SQL -------------------------------------------------
            public function sql_addReminder($form_data){
                $reminder_date = $form_data[0]['value'] ? $form_data[0]['value'] : null;
                $description = $form_data[1]['value'];
                $priority = $form_data[2]['value'];
                $emails = $form_data[3]['value'];
                $this -> connect();
                    $query = "INSERT INTO reminders (created_date, reminder_date, priority, description, emails )
                              VALUES (NOW(), :reminder_date, :priority, :description, :emails)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':reminder_date', $reminder_date);
                    $sql -> bindParam(':priority', $priority);
                    $sql -> bindParam(':description', $description);
                    $sql -> bindParam(':emails', $emails);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'reminderAdded';
                $output -> reminder_date = $reminder_date;
                $output -> description = $description;
                $output -> priority = $priority;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Edit reminder form -----------------------------------------------
            public function form_editReminder(){
                echo "EDIT REMINDER";
            }
        // ---------------------------------------------------------------------

        // -- Edit reminder SQL ------------------------------------------------
            public function sql_editReminder($form_data){
                echo "<p>Edit reminder</p>";
            }
        // ---------------------------------------------------------------------

    }

?>
