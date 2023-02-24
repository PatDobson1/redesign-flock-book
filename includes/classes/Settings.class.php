<?php

    class Settings extends Db{

        // -- Change password form ----------------------------------------------
            public function form_changePassword(){
                $form_element = new FormElements();
                echo "<div class='form_container change_password form_hide'>";
                    echo "<h3>Change password</h3>";
                    echo "<form name='change_password' class='col_3 js_form' data-action='change_password'>";
                        echo "<div>
                              <p class='required'>
                                <label for='password'>New password</label>
                                <input type='password' name='password' data-validation='required' data-errormessage='Please enter a password' />
                                <input type='hidden' name='id' value='$_SESSION[userId]' />
                              </p>";
                            $form_element -> submit('Change password');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Change password --------------------------------------------------
            public function sql_changePassword($form_data){
                $password = password_hash($form_data[0]['value'], PASSWORD_DEFAULT);
                $id = $form_data[1]['value'];
                $this -> connect();
                    $query = "UPDATE users SET user_password = :password WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':password', $password);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();
                $output = new stdClass();
                $output -> action = 'passwordChanged';
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

    }

?>
