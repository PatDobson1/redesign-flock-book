<?php

    class FormElements{

        public function input($type, $name, $text, $required, $validation, $error, $selectOptions){

            $class = $required ? " class='required'" : "";

            switch($type){
                case 'text':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <input type='$type' name='$name' data-validation='$validation' data-errormessage='$error' />
                                </p>";
                    break;
                case 'date':
                    $input = "  <p $class>
                                    <label for='$name'>$text</label>
                                    <input type='$type' name='$name' data-validation='$validation' data-errormessage='$error' class='datepicker' id='$name' />
                                </p>";
                    break;
                case 'hidden':
                    $input = "  <input type='$type' name='$name'  />";
                    break;
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
                case 'control':
                    $input = "  <p class='form_control'>
                                    <input type='submit' value='$text' />
                                </p>";
                    break;
                case 'submit':
                    $input = "  <p class='form_control'>
                                    <input type='submit' value='$text' />
                                </p>";
                    break;
                case 'required':
                    $input = "  <p class='required-warning'><span>*</span> - Required information</p>";
                    break;
            }

            echo $input;

        }

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

    }

?>
