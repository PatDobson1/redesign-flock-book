<?php

    class Generic extends Db{


        // -- Get species based on id ------------------------------------------
            public function getSpecies($id){
                $query = "SELECT species FROM species WHERE :id = id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['species'];
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get breed based on id --------------------------------------------
            public function getBreed($id){
                $query = "SELECT breed_name FROM breed WHERE :id = id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['breed_name'];
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get supplier based on id -----------------------------------------
            public function getSupplier($id){
                $query = "SELECT supplier_name FROM supplier WHERE :id = id";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $row = $sql -> fetch();
                    return $row['supplier_name'];
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get species list [select options] --------------------------------
            public function getSpeciesList(){
                $query = "SELECT id, species FROM species ORDER BY species";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $output = '';
                    $output .= "<option value='null'>Please select a species</option>";
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output .= "<option value='$row[id]'>$row[species]</option>";
                    }
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get breed list [select options] ----------------------------------
            public function getBreedList($species, $return_action){
                $query = "  SELECT id AS value, breed_name AS text
                            FROM breed
                            WHERE species = :species
                            ORDER BY breed_name";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> execute();
                    $results = array();

                    $output = new stdClass();
                    $output -> action = 'breedList';
                    $output -> returnAction = $return_action;
                    $html = '';
                    $html .= "<option value='null'>Please select a breed</option>";
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $html .= "<option value='$row[value]'>$row[text]</option>";
                    }
                    $output -> html = $html;
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get mothers list -------------------------------------------------
            public function getMothersList($species, $return_action){
                $query = "  SELECT livestock_name, uk_tag_no, id
                            FROM livestock
                            WHERE gender = 2 AND species = :species
                            ORDER BY livestock_name, uk_tag_no";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> execute();
                    $results = array();
                    $output = new stdClass();
                        $output -> action = 'mothersList';
                        $output -> returnAction = $return_action;
                        $html = '';
                        $html = '';
                        $html .= "<option value='null'>Please select a mother</option>";
                        while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                            if( $row['livestock_name'] && $row['uk_tag_no'] ){
                                $text = "$row[uk_tag_no] ( $row[livestock_name] )";
                            }elseif (!$row['uk_tag_no']){
                                $text = $row['livestock_name'];
                            }else{
                                $text = $row['uk_tag_no'];
                            }
                            $html .= "<option value='$row[id]'>$text</option>";
                        }
                        $output -> html = $html;
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get fathers list -------------------------------------------------
            public function getFathersList($species, $return_action){
                $query = "  SELECT livestock_name, uk_tag_no, id
                            FROM livestock
                            WHERE gender = 1 AND species = :species
                            ORDER BY livestock_name, uk_tag_no";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':species', $species);
                    $sql -> execute();
                    $results = array();
                    $output = new stdClass();
                        $output -> action = 'fatherssList';
                        $output -> returnAction = $return_action;
                        $html = '';
                        $html .= "<option value='null'>Please select a father</option>";
                        while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                            if( $row['livestock_name'] && $row['uk_tag_no'] ){
                                $text = "$row[uk_tag_no] ( $row[livestock_name] )";
                            }elseif (!$row['uk_tag_no']){
                                $text = $row['livestock_name'];
                            }else{
                                $text = $row['uk_tag_no'];
                            }
                            $html .= "<option value='$row[id]'>$text</option>";
                        }
                        $output -> html = $html;
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get gender list [select options] --------------------------------
            public function getGenderList(){
                $query = "SELECT id AS value, gender AS text FROM gender ORDER BY gender";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $results = array();
                    $output = '';
                    $output .= "<option value='null'>Please select a gender</option>";
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output .= "<option value='$row[value]'>$row[text]</option>";
                    }
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Get suppliers list [select options] ------------------------------
            public function getSuppliersList(){
                $query = "SELECT id, supplier_name FROM supplier ORDER BY supplier_name";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();
                    $output = '';
                    $output .= "<option value='null'>Please select a supplier</option>";
                    while( $row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output .= "<option value='$row[id]'>$row[supplier_name]</option>";
                    }
                    return $output;
                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

    }

?>
