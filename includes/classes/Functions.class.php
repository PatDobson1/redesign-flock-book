<?php

    class Functions extends Db{

        // -- Plain date format (dd mmmm yyyy) ---------------------------------
            public function dateFormat($date){

                if($date){
                    $formatted_date = date_create($date);
                    return date_format( $formatted_date,"j F Y" );
                }else{
                    return 'n/a';
                }

            }
        // ---------------------------------------------------------------------

        // -- Date format ------------------------------------------------------
            public function cardDateFormat($date){

                if($date){
                    $formatted_date = date_create($date);
                    $day = date_format( $formatted_date,"j" );
                    $month = date_format( $formatted_date,"M" );
                    $year = date_format( $formatted_date,"Y" );
                    $html = "<p class='date'>
                                <span>$day</span>
                                <span>$month</span>
                                <span>$year</span>
                             </p>";
                    return $html;
                }else{
                    return 'n/a';
                }

            }
        // ---------------------------------------------------------------------

        // -- Currency format --------------------------------------------------
            public function currencyFormat($number){

                return "&pound;" . number_format($number,2);

            }
        // ---------------------------------------------------------------------

    }

?>
