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
                    case 'quickView':
                        $livestock = new Livestock();
                        $livestock -> animalQuickView($site_data, $id);
                        break;
                    case 'familyTree':
                        $livestock = new Livestock();
                        $livestock -> buildFamilyTree();
                        break;
                }
            }
        // ---------------------------------------------------------------------

    }

?>
