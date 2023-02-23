<?php

    class Supplier extends Db{

        // -- Supplier card ----------------------------------------------------
            public function getAllSuppliers($site_data){

                $this -> connect();

                    $query = "  SELECT *
                                FROM supplier
                                WHERE deleted = 0
                                ORDER BY supplier_name ASC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    echo "<table class='sortable suppliers_table'>
                            <tr>
                                <th>Name</th>
                                <th>Supplies</th>
                                <th class='no_sort'>Telephone</th>
                                <th class='no_sort'>Email</th>
                                <th class='no_sort'>Website</th>
                                <th class='delete_col no_sort'></th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        // -- Validate email and url ---------------------------
                            if( $row['website'] ){
                                $url = strpos($row['website'], 'http://') === 0 || strpos($row['website'], 'https://') === 0 ? $row['website'] : 'http://' . $row['website'];
                                $url = "<a class='tableLink' href='$url' target='_blank'>Website</a>";
                            }else{
                                $url = '';
                            }
                            $row['email'] = filter_var($row['email'], FILTER_VALIDATE_EMAIL) ? $row['email'] : null;
                            $email = $row['email'] ? "<a class='tableLink' href='mailto:$row[email]'>Email</a>" : "";
                        // -----------------------------------------------------
                        // -- Create delete ------------------------------------
                            $supplierCount = $this -> supplierCount($row['id']);
                            $delete_cell = "<a class='js-delete delete_link' data-id='$row[id]' data-deletetype='supplier'>Delete</a>";
                            $deleteRow = $supplierCount ? '' : $delete_cell;
                        // -----------------------------------------------------
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td class='left'>$row[supplier_name]</th>
                                <td class='left'>$row[supplies]</td>
                                <td class='left'>$row[telephone]</td>
                                <td class='cen'>$email</td>
                                <td class='cen'>$url</td>
                                <td>$deleteRow</td>
                            </tr>";
                    }
                    echo "</table>";
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Add supplier form ------------------------------------------------
            public function form_addSupplier(){
                $generic = new Generic();
                $form_element = new FormElements();
                echo "<div class='form_container add_supplier form_hide'>";
                    echo "<h3>Add supplier</h3>";
                    echo "<form name='add_feed' class='col_2 js_form' data-action='add_supplier'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('supplier_name', 'Supplier name', true, 'required', 'Please enter a supplier name');
                            $form_element -> text('supplies', 'Supplies', false, '', '');
                            $form_element -> input('textarea', 'address', 'Address', false, '', '','');
                            $form_element -> text('telephone', 'Telephone', false, '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> text('email', 'Email', false, '', '');
                            $form_element -> text('website', 'Website', false, '', '');
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '','');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> submit('Add Supplier');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add supplier -----------------------------------------------------
            public function sql_addSupplier($form_data){

                $supplier_name = $form_data[0]['value'];
                $supplies = $form_data[1]['value'];
                $address = $form_data[2]['value'];
                $telephone = $form_data[3]['value'];
                $email = $form_data[4]['value'];
                $website = $form_data[5]['value'];
                $notes = $form_data[6]['value'];

                $this -> connect();
                    $query = "INSERT INTO supplier (supplier_name, supplies, address, website, email, telephone, notes)
                              VALUES (:supplier_name, :supplies, :address, :website, :email, :telephone, :notes)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':supplier_name', $supplier_name);
                    $sql -> bindParam(':supplies', $supplies);
                    $sql -> bindParam(':address', $address);
                    $sql -> bindParam(':telephone', $telephone);
                    $sql -> bindParam(':email', $email);
                    $sql -> bindParam(':website', $website);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                $output -> action = 'supplierAdded';
                $output -> supplier_name = $supplier_name;
                $output -> supplies = $supplies;
                $output -> email = $email;
                $output -> telephone = $telephone;
                $output -> website = $website;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Supplier card ----------------------------------------------------
            public function supplierCard($site_data, $id, $context){

                $this -> connect();
                    $query = "SELECT * FROM supplier WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $data = '';
                $data .= "<p class='controls'>";
                    $data .= "<a href='$site_data[site_root]/suppliers' class='back'>Back to suppliers</a>";
                    $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='supplier' data-form='edit_supplier'>Edit supplier</a>";
                $data .= "</p>";

                $data .= "<div class='card supplierCard'>";
                    $data .= "<h2>Supplier details</h2>";
                    $data .= "<div class='col_2'>";
                        $data .= "<div>";
                            $data .= "<p><label>Supplier name:</label>$row[supplier_name]</p>";
                            $data .= "<p><label>Supplies:</label>$row[supplies]</p>";
                            $data .= "<p><label>Telephone:</label>$row[telephone]</p>";
                        $data.= "</div>";
                        $data.= "<div>";
                            $data .= "<p><label>Email:</label>$row[email]</p>";
                            $data .= "<p><label>Website:</label>$row[website]</p>";
                        $data .= "</div>";
                    $data .= "</div>";
                    $data .= "<div>";
                        $data .= "<p class='fullWidth'><label>Address:</label>$row[address]</p>";
                        $data .= "<p class='fullWidth'><label>Notes:</label>$row[notes]</p>";
                    $data .= "</div>";
                $data .= "</div>";

                if($context == 'echo'){
                    echo $data;
                }else{
                    return $data;
                }

            }
        // ---------------------------------------------------------------------

        // -- Edit supplier form -----------------------------------------------
            public function form_editSupplier(){
                $generic = new Generic();
                $form_element = new FormElements();
                echo "<div class='form_container edit_supplier form_hide'>";
                    echo "<h3>Edit supplier</h3>";
                    echo "<form name='add_feed' class='col_2 js_form' data-action='edit_supplier'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('supplier_name', 'Supplier name', true, 'required', 'Please enter a supplier name');
                            $form_element -> text('supplies', 'Supplies', false, '', '');
                            $form_element -> input('textarea', 'address', 'Address', false, '', '','');
                            $form_element -> text('telephone', 'Telephone', false, '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> text('email', 'Email', false, '', '');
                            $form_element -> text('website', 'Website', false, '', '');
                            $form_element -> input('textarea', 'notes', 'Notes', false, '', '','');
                            $form_element -> hidden('id');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> submit('Edit Supplier');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Get supplier -----------------------------------------------------
            public function sql_getSupplier($id){

                $this -> connect();
                    $query = "SELECT * FROM supplier WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $output = new stdClass();
                    if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output -> id = $row['id'];
                        $output -> supplier_name = $row['supplier_name'];
                        $output -> supplies = $row['supplies'];
                        $output -> telephone = $row['telephone'];
                        $output -> email = $row['email'];
                        $output -> website = $row['website'];
                        $output -> address = $row['address'];
                        $output -> notes = $row['notes'];
                        $output -> context = 'editSupplier';
                    }
                    echo json_encode($output);
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Edit supplier ----------------------------------------------------
            public function sql_editSupplier($form_data){

                $supplier_name = $form_data[0]['value'];
                $supplies = $form_data[1]['value'];
                $address = $form_data[2]['value'];
                $telephone = $form_data[3]['value'];
                $email = $form_data[4]['value'];
                $website = $form_data[5]['value'];
                $notes = $form_data[6]['value'];
                $id = $form_data[7]['value'];

                $this -> connect();
                    $query = "UPDATE supplier
                              SET   supplier_name = :supplier_name,
                                    supplies = :supplies,
                                    address = :address,
                                    website = :website,
                                    email = :email,
                                    telephone = :telephone,
                                    notes = :notes
                              WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':supplier_name', $supplier_name);
                    $sql -> bindParam(':supplies', $supplies);
                    $sql -> bindParam(':address', $address);
                    $sql -> bindParam(':website', $website);
                    $sql -> bindParam(':email', $email);
                    $sql -> bindParam(':telephone', $telephone);
                    $sql -> bindParam(':notes', $notes);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'supplierEdited';
                    $output -> id = $id;
                    $output -> supplier_name = $supplier_name;
                    $output -> supplies = $supplies;
                    $output -> email = $email;
                    $output -> telephone = $telephone;
                    $output -> website = $website;
                echo json_encode($output);
            }
        // ---------------------------------------------------------------------

        // -- Count suppliers --------------------------------------------------
            public function supplierCount($supplier){

                $this -> connect();
                    // -- Count feed --
                        $query = "  SELECT COUNT(supplier) AS supplierCount
                                    FROM feed
                                    WHERE supplier = :supplier";
                        $sql = self::$conn -> prepare($query);
                        $sql -> bindParam(":supplier", $supplier);
                        $sql -> execute();
                        $row = $sql -> fetch();
                        $feedCount = $row['supplierCount'];
                    // -- Count medicine --
                        $query = "  SELECT COUNT(supplier) AS supplierCount
                                    FROM medicine
                                    WHERE supplier = :supplier";
                        $sql = self::$conn -> prepare($query);
                        $sql -> bindParam(":supplier", $supplier);
                        $sql -> execute();
                        $row = $sql -> fetch();
                        $medicineCount = $row['supplierCount'];
                $this -> disconnect();

                $allCount = $feedCount + $medicineCount;
                return $allCount;

            }
        // ---------------------------------------------------------------------

        // -- Delete supplier --------------------------------------------------
            public function sql_deleteSupplier($form_data){

                $id = $form_data[0]['value'];
                $this -> connect();
                    $query = "DELETE FROM supplier WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $output = new stdClass();
                    $output -> action = 'supplierDeleted';
                    $output -> id = $id;
                    echo json_encode($output);
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

    }

?>
