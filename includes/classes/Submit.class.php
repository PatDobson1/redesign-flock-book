<?php

    class Submit{

        // -- Form submit ------------------------------------------------------
            public function submitForm($payload){
                $form_action = $payload['action'];
                $form_data = $payload['formData'];

                switch($form_action){
                    // -- Species ----------------------------------------
                        case 'add_species':
                            $species = new Species();
                            $species -> sql_addSpecies($form_data);
                            break;
                        case 'edit_species':
                            $species = new Species();
                            $species -> sql_editSpecies($form_data);
                            break;
                        case 'delete_species':
                            $species = new Species();
                            $species -> sql_deleteSpecies($form_data);
                            break;
                        // -- Breeds -----------------------------------------
                        case 'add_breed':
                            $breeds = new Breeds();
                            $breeds -> sql_addBreed($form_data);
                            break;
                        case 'edit_breed':
                            $breeds = new Breeds();
                            $breeds -> sql_editBreed($form_data);
                            break;
                        case 'delete_breed':
                            $breeds = new Breeds();
                            $breeds -> sql_deleteBreed($form_data);
                            break;
                        // -- Livestock --------------------------------------
                        case 'add_livestock':
                            $livestock = new Livestock();
                            $livestock -> sql_addLivestock($form_data);
                            break;
                        // -- Search -----------------------------------------
                        case 'search_livestock':
                            $search = new Search();
                            $search -> livestock_freeText($form_data);
                            break;
                        // -- Filter -----------------------------------------
                        case  'filter_results':
                            $livestock = new Livestock();
                            $livestock -> livestock_filter($form_data);
                            break;
                }
            }
        // ---------------------------------------------------------------------

    }

?>
