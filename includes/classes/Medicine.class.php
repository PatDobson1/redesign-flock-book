<?php

    class Medicine extends Db{

        // -- Current medicine card --------------------------------------------
            public function currentMedicineCard(){

                $this -> connect();

                    $query = "  SELECT *
                                FROM medicine
                                WHERE finished_date IS null
                                ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    echo "<table class='sortable medicine_table'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Batch number</th>
                                <th>Description</th>
                                <th class='delete_col no_sort'></th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        $finished_cell = "<a class='js-finish tableLink' data-id='$row[id]' data-type='medicine'>Finished</a>";
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td>$row[medicine_name]</th>
                                <td>$row[purchase_date]</td>
                                <td>$row[expiry_date]</td>
                                <td>$row[batch_number]</td>
                                <td>$row[description]</td>
                                <td>$finished_cell</td>
                            </tr>";
                    }

                    echo "</table>";
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Finished medicine card -------------------------------------------
            public function finishedMedicineCard($year){

                $this -> connect();

                    $query = "  SELECT *
                                FROM medicine
                                WHERE finished_date IS NOT null AND YEAR(purchase_date) = :year
                                ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':year', $year);
                    $sql -> execute();

                    echo "<table class='sortable feed_table'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Batch number</th>
                                <th>Description</th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td>$row[medicine_name]</th>
                                <td>$row[purchase_date]</td>
                                <td>$row[expiry_date]</td>
                                <td>$row[batch_number]</td>
                                <td>$row[description]</td>
                            </tr>";
                    }

                    echo "</table>";
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Medicine years ---------------------------------------------------
            public function getMedicineYears(){

                $this -> connect();

                    $query = "SELECT DISTINCT YEAR(purchase_date) AS year
                              FROM medicine
                              ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    $years = array();
                    while( $row = $sql -> fetch() ){
                        array_push($years, $row['year']);
                    }
                    return $years;

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

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

        // -- Add medicine form ------------------------------------------------
            public function form_addMedicine(){
                $generic = new Generic();
                $form_element = new FormElements();
                $supplier_list =  $generic -> getSuppliersList('','');
                echo "<div class='form_container add_medicine form_hide'>";
                    echo "<h3>Add medicine</h3>";
                    echo "<form name='add_medicine' class='col_2 js_form' data-action='add_medicine'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('text', 'medicine_name', 'Medicine name', true, 'required', 'Please enter a medicine name','');
                            $form_element -> input('select', 'supplier', 'Supplier', true, 'required', 'Please select a supplier', $supplier_list);
                            $form_element -> input('date', 'purchase_date', 'Purchase date', true, 'required', 'Please enter a purchase date','');
                            $form_element -> input('date', 'expiry_date', 'Expiration date', false, '', '','');
                            $form_element -> input('date', 'finished_date', 'Finished date', false, '', '','');
                            $form_element -> input('submit', '', 'Add medicine', false, '', '','');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('text', 'batch_number', 'Batch number', false, '', '','');
                            $form_element -> input('text', 'price', 'Price', false, '', '','');
                            $form_element -> input('text', 'quantity', 'Quantity', false, '', '','');
                            $form_element -> input('textarea', 'description', 'Description', false, '', '', '');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add medicine -----------------------------------------------------
            public function sql_addMedicine($form_data){

                $medicine_name = $form_data[0]['value'];
                $supplier = $form_data[1]['value'];
                $purchase_date = $form_data[2]['value'] ? $form_data[2]['value'] : null;
                $expiry_date = $form_data[3]['value'] ? $form_data[3]['value'] : null;
                $finished_date = $form_data[4]['value'] ? $form_data[4]['value'] : null;
                $batch_number = $form_data[5]['value'];
                $price = $form_data[6]['value'];
                $quantity = $form_data[7]['value'];
                $description = $form_data[8]['value'];

                $this -> connect();

                    $query = "  INSERT INTO medicine (medicine_name, supplier, purchase_date, expiry_date, finished_date, batch_number, price, quantity, description)
                                VALUES (:medicine_name, :supplier, :purchase_date, :expiry_date, :finished_date, :batch_number, :price, :quantity, :description)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':medicine_name', $medicine_name);
                    $sql -> bindParam(':supplier', $supplier);
                    $sql -> bindParam(':purchase_date', $purchase_date);
                    $sql -> bindParam(':expiry_date', $expiry_date);
                    $sql -> bindParam(':finished_date', $finished_date);
                    $sql -> bindParam(':batch_number', $batch_number);
                    $sql -> bindParam(':price', $price);
                    $sql -> bindParam(':quantity', $quantity);
                    $sql -> bindParam(':description', $description);
                    $sql -> execute();

                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'medicineAdded';
                    $output -> medicine_name = $medicine_name;
                    $output -> purchase_date = $purchase_date;
                    $output -> expiration_date = $expiry_date;
                    $output -> batch_number = $batch_number;
                    $output -> description = $description;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Medicine card ----------------------------------------------------
            public function medicineCard($site_data, $id, $returnType){

                $functions = new Functions();

                $this -> connect();
                    $query = "  SELECT medicine.id AS medicine_id, medicine_name, purchase_date, batch_number, expiry_date, finished_date,
                                       price, quantity, description, supplier.supplier_name AS supplier_name
                                FROM medicine
                                INNER JOIN supplier ON supplier.id
                                WHERE medicine.id = :id AND supplier = supplier.id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $purchase_date = $functions -> dateFormat($row['purchase_date']);
                $medicine_name = $row['medicine_name'];
                $batch_number = $row['batch_number'];
                $expiry_date = $functions -> dateFormat($row['expiry_date']);
                $finished_date = $functions -> dateFormat($row['finished_date']);
                $supplier = $row['supplier_name'];
                $price = $functions -> currencyFormat($row['price']);
                $quantity = $row['quantity'];
                $description = $row['description'];

                $data  = '';
                $data .= "<p class='controls'>";
                    $data .= "<a href='$site_data[site_root]/medicine' class='back'>Back to medicine</a>";
                    $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='medicine' data-form='edit_medicine'>Edit medicine</a>";
                $data .= "</p>";
                $data .= "<div class='card medicineCard'>";
                $data .= "  <h2>Medicine details</h2>";
                $data .= "  <div class='col_2'>";
                $data .= "      <div>";
                $data .= "          <p><label>Medicine name:</label>$medicine_name</p>";
                $data .= "          <p><label>Source</label>$supplier</p>";
                $data .= "          <p><label>Purchase date:</label>$purchase_date</p>";
                $data .= "          <p><label>Expiration date</label>$expiry_date</p>";
                $data .= "          <p><label>Finished date</label>$finished_date</p>";
                $data .= "      </div>";
                $data .= "      <div>";
                $data .= "          <p><label>Batch number</label>$batch_number</p>";
                $data .= "          <p><label>Price</label>$price</p>";
                $data .= "          <p><label>Quantity</label>$quantity</p>";
                $data .= "      </div>";
                $data .= "  </div>";
                $data.= "   <div>";
                $data.= "       <p class='fullWidth'><label>Description:</label>$description</p>";
                $data.= "   </div>";
                $data .= "</div>";

                if( $returnType == 'echo' ){
                    echo $data;
                }else{
                    return $data;
                }

            }
        // ---------------------------------------------------------------------

        // -- Edit medicine form -----------------------------------------------
            public function form_editMedicine(){
                $generic = new Generic();
                $form_element = new FormElements();
                $supplier_list =  $generic -> getSuppliersList('','');
                echo "<div class='form_container edit_medicine form_hide'>";
                    echo "<h3>Edit medicine</h3>";
                    echo "<form name='edit_medicine' class='col_2 js_form' data-action='edit_medicine'>";
                        echo "<div>";
                            $form_element -> input('required', '', '', false, '', '','');
                            $form_element -> input('text', 'medicine_name', 'Medicine name', true, 'required', 'Please enter a medicine name','');
                            $form_element -> input('select', 'supplier', 'Supplier', true, 'required', 'Please select a supplier', $supplier_list);
                            $form_element -> input('date', 'purchase_date', 'Purchase date', true, 'required', 'Please enter a purchase date','');
                            $form_element -> input('date', 'expiry_date', 'Expiration date', false, '', '','');
                            $form_element -> input('date', 'finished_date', 'Finished date', false, '', '','');
                            $form_element -> input('submit', '', 'Edit medicine', false, '', '','');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> input('text', 'batch_number', 'Batch number', false, '', '','');
                            $form_element -> input('text', 'price', 'Price', false, '', '','');
                            $form_element -> input('text', 'quantity', 'Quantity', false, '', '','');
                            $form_element -> input('textarea', 'description', 'Description', false, '', '', '');
                            $form_element -> input('hidden', 'id', 'id', false, '', '','');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Get medicine -----------------------------------------------------
            public function sql_getMedicine($id){

                $this -> connect();

                    $query = "SELECT * FROM medicine WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $output = new stdClass();
                    if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output -> id = $id;
                        $output -> medicine_name = $row['medicine_name'];
                        $output -> supplier = $row['supplier'];
                        $output -> purchase_date = $row['purchase_date'];
                        $output -> expiry_date = $row['expiry_date'];
                        $output -> finished_date = $row['finished_date'];
                        $output -> batch_number = $row['batch_number'];
                        $output -> price = $row['price'];
                        $output -> quantity = $row['quantity'];
                        $output -> description = $row['description'];
                        $output -> context = 'editMedicine';
                    }
                    echo json_encode($output);

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Edit medicine ----------------------------------------------------
            public function sql_editMedicine($form_data){

                $medicine_name = $form_data[0]['value'];
                $supplier = $form_data[1]['value'];
                $purchase_date = $form_data[2]['value'] ? $form_data[2]['value'] : null;
                $expiry_date = $form_data[3]['value'] ? $form_data[3]['value'] : null;
                $finished_date = $form_data[4]['value'] ? $form_data[4]['value'] : null;
                $batch_number = $form_data[5]['value'];
                $price = $form_data[6]['value'];
                $quantity = $form_data[7]['value'];
                $description = $form_data[8]['value'];
                $id = $form_data[9]['value'];

                $this -> connect();

                    $query = "  UPDATE medicine
                                SET medicine_name = :medicine_name,
                                    supplier = :supplier,
                                    purchase_date = :purchase_date,
                                    expiry_date = :expiry_date,
                                    finished_date = :finished_date,
                                    batch_number = :batch_number,
                                    price = :price,
                                    quantity = :quantity,
                                    description = :description
                                WHERE id = :id";

                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':medicine_name', $medicine_name);
                    $sql -> bindParam(':supplier', $supplier);
                    $sql -> bindParam(':purchase_date', $purchase_date);
                    $sql -> bindParam(':expiry_date', $expiry_date);
                    $sql -> bindParam(':finished_date', $finished_date);
                    $sql -> bindParam(':batch_number', $batch_number);
                    $sql -> bindParam(':price', $price);
                    $sql -> bindParam(':quantity', $quantity);
                    $sql -> bindParam(':description', $description);
                    $sql -> execute();

                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'medicineEdited';
                    $output -> id = $id;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Mark medicine finished -------------------------------------------
            public function sql_markMedicineFinished($form_data){

                $id = $form_data[0]['value'];

                $this -> connect();
                    $query = "UPDATE medicine SET finished_date = now() WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'medicineFinished';
                    $output -> id = $id;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

    }

?>
