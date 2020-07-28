<?php

    class Submit extends Db{

        // -- Form submit ------------------------------------------------------
            public function submitForm($payload){
                $form_action = $payload['action'];
                $form_data = $payload['formData'];
                var_dump($form_data);
                echo "species added";
            }
        // ---------------------------------------------------------------------

    }

?>
