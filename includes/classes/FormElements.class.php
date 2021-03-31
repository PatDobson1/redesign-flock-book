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

    }

?>
