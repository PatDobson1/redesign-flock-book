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
                                    <select name='$name'>$selectOptions</select>
                                </p>";
                    break;
                case 'control':
                    $input = "  <p class='form_control'>
                                    <input type='submit' value='$text' /><input type='reset' value='Reset' />
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
