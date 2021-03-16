<?php

    class Submit{

        // -- Form submit ------------------------------------------------------
            public function submitForm($payload, $site_data){
                $form_action = $payload['action'];
                $form_data = $payload['formData'];

                switch($form_action){

                    // -- Species ----------------------------------------------
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
                    // ---------------------------------------------------------

                    // -- Breeds -----------------------------------------------
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
                    // ---------------------------------------------------------

                    // -- Livestock --------------------------------------------
                        case 'add_livestock':
                            $livestock = new Livestock();
                            $livestock -> sql_addLivestock($form_data);
                        break;
                        case 'edit_livestock':
                            $livestock = new Livestock();
                            $livestock -> sql_editLivestock($form_data);
                        break;
                        case 'delete_livestock':
                            $livestock = new Livestock();
                            $livestock -> sql_deleteLivestock($form_data, $site_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Search -----------------------------------------------
                        case 'search_livestock':
                            $search = new Search();
                            $search -> livestock_freeText($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Suppliers --------------------------------------------
                        case 'add_supplier':
                            $suppier = new Supplier();
                            $suppier -> sql_addSupplier($form_data);
                        break;
                        case 'edit_supplier':
                            $suppier = new Supplier();
                            $suppier -> sql_editSupplier($form_data);
                        break;
                        case 'delete_supplier':
                            $supplier = new Supplier();
                            $supplier -> sql_deleteSupplier($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Feed -------------------------------------------------
                        case 'add_feed':
                            $feed = new Feed();
                            $feed -> sql_addFeed($form_data);
                        break;
                        case 'finish_feed':
                            $feed = new Feed();
                            $feed -> sql_markFeedFinshed($form_data);
                        break;
                    // ---------------------------------------------------------

                }
            }
        // ---------------------------------------------------------------------

    }

?>
