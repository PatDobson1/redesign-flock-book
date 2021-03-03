<?php

    class Medicine extends Db{

        // -- Get medicines based on id ----------------------------------------
            public function getMedicine($id){

                $query = "  SELECT * FROM medicine WHERE id = :id";
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
