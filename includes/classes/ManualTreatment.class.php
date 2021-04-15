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

        // -- Manual treatment card --------------------------------------------
            public function manualTreatmentCard($site_data){

                $functions = new Functions();
                $generic = new Generic();

                $this -> connect();

                    $query = "SELECT * FROM manual_treatment ORDER BY treatment_name";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    echo "<table class='sortable manualTreatment_table'>
                            <tr>
                                <th>Name</th>
                                <th>Supplier</th>
                                <th>Price</th>
                                <th class='delete_col no_sort'></th>
                            </tr>";
                            while( $row = $sql -> fetch() ){
                                $price = $functions -> currencyFormat($row['price']);
                                $supplier = $generic -> getSupplier($row['supplier']);
                                echo "  <tr data-id='$row[id]' class='js-view'>
                                            <td class='left'>$row[treatment_name]</td>
                                            <td class='left'>$supplier</td>
                                            <td>$price</td>
                                            <td></td>
                                        </tr>";
                            }
                    echo "</table>";

                $this -> disconnect();
            }
        // ---------------------------------------------------------------------

        // -- Manual treatment single card -------------------------------------
            public function manualTreatmentCardSingle($site_data, $id, $returnType){

                $functions = new Functions();
                $generic = new Generic();

                $this -> connect();

                    $query = "SELECT * FROM manual_treatment WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();

                    $row = $sql -> fetch();

                    $name = $row['treatment_name'];
                    $price = $functions -> currencyFormat($row['price']);
                    $notes = $row['notes'];
                    $supplier = $generic -> getSupplier($row['supplier']);

                    $data  = '';
                    $data .= "<p class='controls'>";
                        $data .= "<a href='$site_data[site_root]/manualTreatment' class='back'>Back to manual treatment</a>";
                        $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='manualTreatment' data-form='edit_manualTreatment'>Edit manual treatment</a>";
                    $data .= "</p>";
                    $data .= "<div class='card manualTreatmentCard'>";
                    $data .= "  <h2>Manual treatment details</h2>";
                    $data .= "  <div class='col_2'>";
                    $data .= "      <div>";
                    $data .= "          <p><label>Treatment name:</label>$name</p>";
                    $data .= "          <p><label>Source</label><a href='$site_data[site_root]/suppliers?id=$row[supplier]'>$supplier</a></p>";
                    $data .= "          <p><label>Price</label>$price</p>";
                    $data .= "      </div>";
                    $data .= "  </div>";
                    $data.= "   <div>";
                    $data.= "       <p class='fullWidth'><label>Notes:</label>$notes</p>";
                    $data.= "   </div>";
                    $data .= "</div>";

                    if( $returnType == 'echo' ){
                        echo $data;
                    }else{
                        return $data;
                    }

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Add manual treatment form ------------------------------------------------
            public function form_addManualTreatment(){
                $generic = new Generic();
                $form_element = new FormElements();
                $supplier_list =  $generic -> getSuppliersList('','');
                echo "<div class='form_container add_manualTreatment form_hide'>";
                    echo "<h3>Add manual treatment</h3>";
                    echo "<form name='add_manualTreatment' class='col_2 js_form' data-action='add_manualTreatment'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('text', 'treatment_name', 'Treatment name', true, 'required', 'Please enter a treatment name','');
                            $form_element -> input('select', 'supplier', 'Supplier', true, 'required', 'Please select a supplier', $supplier_list);
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('text', 'price', 'Price', false, '', '','');
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '', '');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> input('submit', '', 'Add treatment', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add manual treatment -----------------------------------------------------
            public function sql_addManualTreatment($form_data){

                $treatment_name = $form_data[0]['value'];
                $supplier = $form_data[1]['value'];
                $price = $form_data[2]['value'];
                $notes = $form_data[3]['value'];

                $this -> connect();

                    $query = "  INSERT INTO manual_treatment (treatment_name, supplier, price, notes)
                                VALUES (:treatment_name, :supplier, :price, :notes)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':treatment_name', $treatment_name);
                    $sql -> bindParam(':supplier', $supplier);
                    $sql -> bindParam(':price', $price);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> execute();

                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'treatmentAdded';
                    $output -> treatment_name = $treatment_name;
                    $output -> supplier = $supplier;
                    $output -> price = $price;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

    }

?>
