<?php

    class GetData{

        // -- Form submit ------------------------------------------------------
            public function get_form_data($site_data, $payload){

                $table = $payload['table'];
                $id = $payload['id'];

                switch($table){
                    case 'species':
                        $species = new Species();
                        $species -> sql_getSpecies($id);
                        break;
                    case 'breed':
                        $breed = new Breeds();
                        $breed -> sql_getBreed($id);
                        break;
                    case 'livestock':
                        $livestock = new Livestock();
                        $livestock -> sql_getLivestock($id);
                        break;
                    case 'quickView':
                        $livestock = new Livestock();
                        $livestock -> animalQuickView($site_data, $id);
                        break;
                    case 'familyTree':
                        $livestock = new Livestock();
                        $livestock -> buildFamilyTree();
                        break;
                    case 'supplier':
                        $supplier = new Supplier();
                        $supplier -> sql_getSupplier($id);
                        break;
                    case 'feed';
                        $feed = new Feed();
                        $feed -> sql_getFeed($id);
                        break;
                }
            }
        // ---------------------------------------------------------------------

        // -- Call class -------------------------------------------------------
            public function call_class($site_data, $payload){
                $generic = new Generic();
                $livestock = new Livestock();
                $supplier = new Supplier();
                $feed = new Feed();
                switch($payload['class_name']){
                    case 'getBreeds':
                        $breeds_result = $generic -> getBreedList($payload['species'], $payload['return_action']);
                        echo json_encode($breeds_result);
                    break;
                    case 'getMothersList':
                        $mothers_result = $generic -> getMothersList($payload['species'], $payload['return_action']);
                        echo json_encode($mothers_result);
                    break;
                    case 'getFathersList':
                        $fathers_result = $generic -> getFathersList($payload['species'], $payload['return_action']);
                        echo json_encode($fathers_result);
                    break;
                    case 'livestockEdited';
                        $stockDetails = $livestock -> animalCard($site_data, $payload['id'], 'return');
                        $data = array('html' => $stockDetails, 'returnAction' => 'livestockEdited');
                        echo json_encode($data);
                    break;
                    case 'supplierEdited':
                        $supplierDetails = $supplier -> supplierCard($site_data, $payload['id'], 'return');
                        $data = array('html' => $supplierDetails, 'returnAction' => 'supplierEdited');
                        echo json_encode($data);
                    break;
                    case 'feedEdited':
                        $feedDetails = $feed -> feedCard($site_data, $payload['id'], 'return');
                        $data = array('html' => $feedDetails, 'returnAction' => 'feedEdited');
                        echo json_encode($data);
                    break;
                }
            }
        // ---------------------------------------------------------------------

    }

?>
