<?php

    class FormElements{

        // -- Creates a submit element -----------------------------------------
        // -- @param [str] - $text - The text to display on the button --
            public function submit($text){
                $input = "  <p class='form_control'>
                                <input type='submit' value='$text' />
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a text input field ---------------------------------------
        // -- @param [str] - $name - The name of the input
        // -- @param [str] - $label - The label for the $input
        // -- @param [bool] [true/false] - $required - Denotes if the input is required
        // -- @param [str] - $validation - The type of validation to apply
        // -- @param [str] - $error - The error message to display if validation fails
            public function text($name, $label, $required, $validation, $error){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <input type='text' name='$name' data-validation='$validation' data-errormessage='$error' />
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a 'required' message -------------------------------------
            public function required(){
                $input = "  <p class='required-warning'><span>*</span> - Required information</p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a hidden text field --------------------------------------
        // -- @param [str] - $name - The name of the input
            public function hidden($name){
                $input = "  <input type='hidden' name='$name'  />";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a date input ---------------------------------------------
        // -- @param [str] - $name - The name of the input
        // -- @param [str] - $label - The label for the $input
        // -- @param [bool] [true/false] - $required - Denotes if the input is required
        // -- @param [str] - $validation - The type of validation to apply
        // -- @param [str] - $error - The error message to display if validation fails
            public function date($name, $label, $required, $validation, $error){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <input type='date' name='$name' data-validation='$validation' data-errormessage='$error' class='datepicker' id='$name' />
                                <a class='js-clearDate clearDate'></a>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        public function input($type, $name, $text, $required, $validation, $error, $selectOptions){

            $class = $required ? " class='required'" : "";

            switch($type){
                case 'textarea':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <textarea name='$name' data-validation='$validation' data-errormessage='$error'></textarea>
                                </p>";
                    break;
                case 'select':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <select name='$name' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                                </p>";
                    break;
                case 'selectMulti':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <select multiple='true' name='$name' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                                    <a class='js-unselect unselect'>Unselect all</a>
                                </p>";
                    break;
                case 'selectDisabled':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <select name='$name' disabled='disabled' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                                </p>";
                    break;
                case 'checkbox':
                    $input = "  <p class='checkbox'>
                                    <input type='checkbox' value='1' name='$name' id='$name' />
                                    <label for='$name'>$text</label>
                                </p>";
                    break;
                case 'checkbox_close':
                    $input = "  <p class='checkbox close'>
                                    <input type='checkbox' value='1' name='$name' id='$name' />
                                    <label for='$name'>$text</label>
                                </p>";
                    break;
            }

            echo $input;

        }

        // -- Creates a special livestock multiselect field --------------------
        // -- Allows for selection of multiple livestock 
            public function multiselect(){

                $livestock = new Livestock();
                $input = '';

                $input .= "<div class='multiSelect'>";
                    $input .= "<p>";
                        $input .= "<span>Livestock available</span>";
                        $input .= "<select name='livestockSource[]' id='livestockSource' multiple size='10'>";
                            $input .= $livestock -> getAllLivestock();
                        $input .= "</select>";
                        $input .= "<span class='addAll rightArrow'>Add all</span>";
                    $input .= "</p>";
                    $input .= "<p>";
                        $input .= "<span>Livestock selected<span> *</span></span>";
                        $input .= "<select name='livestockSelected[]' id='livestockSelected' multiple size='10' class='validate' data-validation='required' data-errormessage='Please select at least one animal'>";
                        $input .= "</select>";
                        $input .= "<span class='removeAll leftArrow'>Remove all</span>";
                    $input .= "</p>";
                $input .= "</div>";

                echo $input;
            }
        // ---------------------------------------------------------------------

    }

?>
