<?php

    class Submit{

        // -- Form submit ------------------------------------------------------
            public function submitForm($payload){
                $form_action = $payload['action'];
                $form_data = $payload['formData'];

                switch($form_action){
                    case 'add_species':
                        $species = new Species();
                        $species -> sql_addSpecies($form_data);
                        break;
                }
                // var_dump($form_data);
                // echo "species added";
            }
        // ---------------------------------------------------------------------

    }

?>
