<?php

    class Reminders extends Db{

        // -- Reminders card ----------------------------------------------------
            public function remindersCard($edit, $context){
                $this -> connect();
                    $editCell = "<td class='cen' width='150px'>[done]</td>";
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
                            $editCell = "<td class='cen' width='150px'>[not done]</td>";
                        break;
                    }
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    echo "  <table class='reminder_table'>
                                <tr>
                                    <th>Due date</th>
                                    <th>Priority</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>";
                                while( $row = $sql -> fetch() ){
                                $priority = $this -> createPriority($row['priority'], 'p');
                                    $description = nl2br($row['description']);
                                    $data_tag = $edit ? "data-id = '$row[id]' class='js-view'" : '';
                                    echo " <tr $data_tag>
                                                <td class='cen'>$row[reminder_date]</td>
                                                <td width='100px' class='left'>$priority</td>
                                                <td class='left'>$description</td>
                                                $editCell
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

                $this -> connect();

                    $query = "SELECT * FROM reminders WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(":id", $id);
                    $sql -> execute();
                    $row = $sql -> fetch();

                    $priority = $this -> createPriority($row['priority'], 'span');
                    $emailArray = explode(",",$row['emails']);
                    $emails = '';
                    if($emailArray[0] != ''){
                        foreach($emailArray as $email){
                            $emails .= "<span>$email</span>";
                        }
                    }
                    $data = '';
                    $data .= "<p class='controls'>";
                        $data .= "<a href='$site_data[site_root]/reminders' class='back'>Back to reminders</a>";
                        $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='reminder' data-form='edit_reminder'>Edit reminder</a>";
                    $data .= "</p>";
                    $data .= "<div class='card reminderCard'>";
                        $data .= "<h2>Reminder details</h2>";
                        $data .= "<div class='col_2'>";
                            $data .= "<div>";
                                $data .= "<p><label>Due date:</label>$row[reminder_date]</p>";
                                $data .= "<p><label>Created date:</label>$row[created_date]</p>";
                                $data .= "<p><label>Priority:</label>$priority</p>";
                            $data .= "</div>";
                            $data .= "<div>";
                                $data .= "<p><label>Remind me (before):</label>$row[remindMe_before]</p>";
                                $data .= "<p><label>Remind me (after):</label>$row[remindMe_after]</p>";
                            $data .= "</div>";
                        $data .= "</div>";
                        $data .= "<div>";
                            $data .= "<p class='fullWidth'><label>Notes:</label>$row[description]</p>";
                            $data .= "<p class='fullWidth emailDetails'><label>Emails:</label>$emails</p>";
                        $data .= "</div>";
                    $data .= "</div>";
                    if($return == 'echo'){
                        echo $data;
                    }else{
                        return $data;
                    }

                $this -> disconnect();
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
                            $form_element -> input('checkbox_close', 'before_1m', 'Remind me 1 month before', false, '', '', '');
                            $form_element -> input('checkbox_close', 'before_1w', 'Remind me 1 week before', false, '', '', '');
                            $form_element -> input('checkbox_close', 'before_1d', 'Remind me 1 day before', false, '', '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('select', 'priority', 'Priority (5 is highest)', false, '', '',$priorityList);
                            $form_element -> input('textarea', 'emails', 'Email recipients (separate with comma)', false, '', '','');
                            $form_element -> input('checkbox_close', 'after_m', 'After, remind me monthly', false, '', '', '');
                            $form_element -> input('checkbox_close', 'after_w', 'After, remind me weekly', false, '', '', '');
                            $form_element -> input('checkbox_close', 'after_d', 'After, Remind me daily', false, '', '', '');
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

                foreach($form_data as $value){
                    if( $value['name'] == 'reminder_date' ){ $reminder_date = $value['value']; }
                    if( $value['name'] == 'description' ){ $description = $value['value']; }
                    if( $value['name'] == 'priority' ){ $priority = $value['value']; }
                    if( $value['name'] == 'emails' ){ $emails = $value['value']; }
                    if( $value['name'] == 'before_1m' ){ $before_1m = "1 Month"; }
                    if( $value['name'] == 'before_1w' ){ $before_1w = "1 Week"; }
                    if( $value['name'] == 'before_1d' ){ $before_1d = "1 Day"; }
                    if( $value['name'] == 'after_m' ){ $after_m = "Monthly"; }
                    if( $value['name'] == 'after_w' ){ $after_w = "Weekly"; }
                    if( $value['name'] == 'after_d' ){ $after_d = "Daily"; }
                }

                // -- Create before & after arrays ----
                    $before = [];
                    $after = [];
                    if(isset($before_1m)){ array_push($before, $before_1m); }
                    if(isset($before_1w)){ array_push($before, $before_1w); }
                    if(isset($before_1d)){ array_push($before, $before_1d); }
                    if(isset($after_m)){ array_push($after, $after_m); }
                    if(isset($after_w)){ array_push($after, $after_w); }
                    if(isset($after_d)){ array_push($after, $after_d); }
                    $before = implode(",", $before);
                    $after = implode(",", $after);
                // ------------------------------------

                $this -> connect();
                    $query = "INSERT INTO reminders (created_date, reminder_date, priority, description, emails, remindMe_before, remindMe_after )
                              VALUES (NOW(), :reminder_date, :priority, :description, :emails, :before, :after)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':reminder_date', $reminder_date);
                    $sql -> bindParam(':priority', $priority);
                    $sql -> bindParam(':description', $description);
                    $sql -> bindParam(':emails', $emails);
                    $sql -> bindParam(':before', $before);
                    $sql -> bindParam(':after', $after);
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
                $generic = new Generic();
                $form_element = new FormElements();
                $priorityList = "<option value='1' selected>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>";
                echo "<div class='form_container edit_reminder form_hide'>";
                    echo "<h3>Edit reminder</h3>";
                    echo "<form name='edit_reminder' class='col_2 js_form' data-action='edit_reminder'>";
                        echo "<div>";
                            $form_element -> input('hidden', 'id', 'id', false, '', '','');
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('date', 'reminder_date', 'Due date (leave blank for non-dated reminder)', false, '', '','');
                            $form_element -> input('textarea', 'description', 'Notes', true, 'required', 'Please enter some notes', '');
                            $form_element -> input('checkbox_close', 'before_1m', 'Remind me 1 month before', false, '', '', '');
                            $form_element -> input('checkbox_close', 'before_1w', 'Remind me 1 week before', false, '', '', '');
                            $form_element -> input('checkbox_close', 'before_1d', 'Remind me 1 day before', false, '', '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('select', 'priority', 'Priority (5 is highest)', false, '', '',$priorityList);
                            $form_element -> input('textarea', 'emails', 'Email recipients (separate with comma)', false, '', '','');
                            $form_element -> input('checkbox_close', 'after_m', 'After, remind me monthly', false, '', '', '');
                            $form_element -> input('checkbox_close', 'after_w', 'After, remind me weekly', false, '', '', '');
                            $form_element -> input('checkbox_close', 'after_d', 'After, Remind me daily', false, '', '', '');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('submit', '', 'Edit reminder', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Get reminder -----------------------------------------------------
            public function sql_getReminder($id){
                $this -> connect();
                    $query = "SELECT * FROM reminders WHERE :id = id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                    $output -> id = $row['id'];
                    $output -> reminder_date = $row['reminder_date'];
                    $output -> description = $row['description'];
                    $output -> priority = $row['priority'];
                    $output -> emails = $row['emails'];
                    $output -> remindMe_before = $row['remindMe_before'];
                    $output -> remindMe_after = $row['remindMe_after'];
                    echo json_encode($output);
                }
            }
        // ---------------------------------------------------------------------

        // -- Edit reminder SQL ------------------------------------------------
            public function sql_editReminder($form_data){

                foreach($form_data as $value){
                    if( $value['name'] == 'id' ){ $id = $value['value']; }
                    if( $value['name'] == 'reminder_date' ){ $reminder_date = $value['value']; }
                    if( $value['name'] == 'description' ){ $description = $value['value']; }
                    if( $value['name'] == 'priority' ){ $priority = $value['value']; }
                    if( $value['name'] == 'emails' ){ $emails = $value['value']; }
                    if( $value['name'] == 'before_1m' ){ $before_1m = "1 Month"; }
                    if( $value['name'] == 'before_1w' ){ $before_1w = "1 Week"; }
                    if( $value['name'] == 'before_1d' ){ $before_1d = "1 Day"; }
                    if( $value['name'] == 'after_m' ){ $after_m = "Monthly"; }
                    if( $value['name'] == 'after_w' ){ $after_w = "Weekly"; }
                    if( $value['name'] == 'after_d' ){ $after_d = "Daily"; }
                }

                // -- Create before & after arrays ----
                    $before = [];
                    $after = [];
                    if(isset($before_1m)){ array_push($before, $before_1m); }
                    if(isset($before_1w)){ array_push($before, $before_1w); }
                    if(isset($before_1d)){ array_push($before, $before_1d); }
                    if(isset($after_m)){ array_push($after, $after_m); }
                    if(isset($after_w)){ array_push($after, $after_w); }
                    if(isset($after_d)){ array_push($after, $after_d); }
                    $before = implode(",", $before);
                    $after = implode(",", $after);
                // ------------------------------------

                $this -> connect();
                    $query = "UPDATE reminders
                              SET   reminder_date = :reminder_date,
                                    priority = :priority,
                                    description = :description,
                                    emails = :emails,
                                    remindMe_before = :before,
                                    remindMe_after = :after
                              WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':reminder_date', $reminder_date);
                    $sql -> bindParam(':priority', $priority);
                    $sql -> bindParam(':description', $description);
                    $sql -> bindParam(':emails', $emails);
                    $sql -> bindParam(':before', $before);
                    $sql -> bindParam(':after', $after);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'reminderEdited';
                    $output -> id = $id;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Create priority --------------------------------------------------
            private function createPriority($priority, $return){

                switch(true){
                    case $priority > 3:
                        $colour = 'red';
                    break;
                    case $priority == 3:
                        $colour = 'amber';
                    break;
                    case $priority > 0 && $priority < 3:
                        $colour = 'green';
                    break;
                }
                if($return == 'span'){
                    $data = "<span class='priority $colour'>";
                }else{
                    $data = "<p class='priority $colour'>";
                }
                for( $i=0; $i<5; $i++ ){
                    $display = $i + 1;
                    if( $priority > $i ){
                        $data .= "<span>$display</span>";
                    }else{
                        $data .= "<span class='blank'></span>";
                    }
                }
                if($return == 'span'){
                    $data .= "</span>";
                }else{
                    $data .= "</p>";
                }

                return $data;

            }
        // ---------------------------------------------------------------------

    }

?>
