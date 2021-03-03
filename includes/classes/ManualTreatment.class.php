<?php

    class ManualTreatment extends Db{

        // -- Get manual treatment based on id ---------------------------------
            public function getManualTreatment($id){

                $query = "  SELECT * FROM manual_treatment WHERE id = :id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $row = $sql -> fetch();
                $this -> disconnect();
                return $row;

            }
        // ---------------------------------------------------------------------

    }

?>
