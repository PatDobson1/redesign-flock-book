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
                    case 'edit_species':
                        $species = new Species();
                        $species -> sql_editSpecies($form_data);
                        break;
                }
            }
        // ---------------------------------------------------------------------

    }

?>
