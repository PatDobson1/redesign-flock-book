<?php

    class Functions extends Db{

        // -- Date format ------------------------------------------------------
            public function dateFormat($date){

                $formatted_date = date_create($date);
                return date_format( $formatted_date,"j F Y" );

            }
        // ---------------------------------------------------------------------

        // -- Currency format --------------------------------------------------
            public function currencyFormat($number){

                return "&pound;" . number_format($number,2);

            }
        // ---------------------------------------------------------------------

    }

?>
