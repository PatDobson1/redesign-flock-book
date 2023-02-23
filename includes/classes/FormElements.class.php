<?php

    class FormElements{

        // -- Input parameters -------------------------------------------------
            // -- $name [str] - The name of the input
            // -- $label [str] - The label for the $input
            // -- $required [bool] [true/false] - Denotes if the input is required
            // -- $validation [str] - The type of validation to apply
            // -- $error [str] - The error message to display if validation fails
            // -- $selectOptions[str] - The options for the select drop down
        // ---------------------------------------------------------------------

        // -- Creates a submit element -----------------------------------------
            public function submit($text){
                $input = "  <p class='form_control'>
                                <input type='submit' value='$text' />
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a text input field ---------------------------------------
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
            public function hidden($name){
                $input = "  <input type='hidden' name='$name'  />";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a date input ---------------------------------------------
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

        // -- Creates a textarea -----------------------------------------------
            public function textarea($name, $label, $required, $validation, $error){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <textarea name='$name' data-validation='$validation' data-errormessage='$error'></textarea>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a select box ---------------------------------------------
            public function select($name, $label, $required, $validation, $error, $selectOptions){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <select name='$name' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a disabled select box ------------------------------------
            public function selectDisabled($name, $label, $required, $validation, $error, $selectOptions){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <select name='$name' disabled='disabled' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a multi-select drop down ---------------------------------
            public function selectMulti($name, $label, $required, $validation, $error, $selectOptions){
                $class = $required ? " class='required'" : "";
                $input = "  <p $class>
                                <label for='$name'>$label</label>
                                <select multiple='true' name='$name' data-validation='$validation' data-errormessage='$error'>$selectOptions</select>
                                <a class='js-unselect unselect'>Unselect all</a>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a checkbox -----------------------------------------------
            public function checkbox($name, $label){
                $input = "  <p class='checkbox'>
                                <input type='checkbox' value='1' name='$name' id='$name' />
                                <label for='$name'>$label</label>
                            </p>";
                echo $input;
            }
        // ---------------------------------------------------------------------

        // -- Creates a compact checkbox ---------------------------------------
            public function checkboxCompact($name, $label){
                $input = "  <p class='checkbox close'>
                                <input type='checkbox' value='1' name='$name' id='$name' />
                                <label for='$name'>$label</label>
                            </p>";
                echo $input;
            }

        // ---------------------------------------------------------------------

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
