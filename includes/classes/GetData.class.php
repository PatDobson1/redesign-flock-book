<?php

    class GetData{

        // -- Form submit ------------------------------------------------------
            public function get_form_data($payload){
                $table = $payload['table'];
                $id = $payload['id'];

                switch($table){
                    case 'species':
                        $species = new Species();
                        $species -> sql_getSpecies($id);
                        break;
                }
            }
        // ---------------------------------------------------------------------

    }

?>
