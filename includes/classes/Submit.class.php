<?php

    class Submit{

        // -- Form submit ------------------------------------------------------
            public function submitForm($payload, $site_data){

                $form_action = $payload['action'];
                $form_data = $payload['formData'];

                $species = new Species();
                $breeds = new Breeds();
                $livestock = new Livestock();
                $search = new Search();
                $suppier = new Supplier();
                $feed = new Feed();
                $medicine = new Medicine();
                $manualTreatment = new ManualTreatment();
                $diary = new Diary();

                switch($form_action){

                    // -- Species ----------------------------------------------
                        case 'add_species':
                            $species -> sql_addSpecies($form_data);
                        break;
                        case 'edit_species':
                            $species -> sql_editSpecies($form_data);
                        break;
                        case 'delete_species':
                            $species -> sql_deleteSpecies($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Breeds -----------------------------------------------
                        case 'add_breed':
                            $breeds -> sql_addBreed($form_data);
                        break;
                        case 'edit_breed':
                            $breeds -> sql_editBreed($form_data);
                        break;
                        case 'delete_breed':
                            $breeds -> sql_deleteBreed($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Livestock --------------------------------------------
                        case 'add_livestock':
                            $livestock -> sql_addLivestock($form_data);
                        break;
                        case 'edit_livestock':
                            $livestock -> sql_editLivestock($form_data);
                        break;
                        case 'delete_livestock':
                            $livestock -> sql_deleteLivestock($form_data, $site_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Search -----------------------------------------------
                        case 'search_livestock':
                            $search -> livestock_freeText($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Suppliers --------------------------------------------
                        case 'add_supplier':
                            $suppier -> sql_addSupplier($form_data);
                        break;
                        case 'edit_supplier':
                            $suppier -> sql_editSupplier($form_data);
                        break;
                        case 'delete_supplier':
                            $supplier -> sql_deleteSupplier($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Feed -------------------------------------------------
                        case 'add_feed':
                            $feed -> sql_addFeed($form_data);
                        break;
                        case 'finish_feed':
                            $feed -> sql_markFeedFinished($form_data);
                        break;
                        case 'edit_feed':
                            $feed -> sql_editFeed($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Medicine ---------------------------------------------
                        case 'add_medicine':
                            $medicine -> sql_addMedicine($form_data);
                        break;
                        case 'finish_medicine':
                            $medicine -> sql_markMedicineFinished($form_data);
                        break;
                        case 'edit_medicine':
                            $medicine -> sql_editMedicine($form_data);
                        break;
                    // ---------------------------------------------------------

                    // -- Manual treatment -------------------------------------
                        case 'add_manualTreatment':
                            $manualTreatment -> sql_addManualTreatment($form_data);
                        break;
                        case 'edit_manualTreatment':
                            echo "E D I T  manual treatment";
                        break;
                    // ---------------------------------------------------------

                    // -- Diary ------------------------------------------------
                        case 'add_diary':
                            $diary -> sql_addDiary($form_data);
                        break;
                        case 'edit_diary':
                            $diary -> sql_editDiary($form_data);
                        break;
                    // ---------------------------------------------------------

                }
            }
        // ---------------------------------------------------------------------

    }

?>
