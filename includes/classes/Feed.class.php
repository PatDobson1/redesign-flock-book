<?php

    class Feed extends Db{

        // -- Current feed card ------------------------------------------------
            public function currentFeedCard($site_data){

                $this -> connect();

                    $query = "  SELECT *
                                FROM feed
                                WHERE finished_date IS null
                                ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> execute();

                    echo "<table class='sortable feed_table'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Batch number</th>
                                <th class='delete_col no_sort'></th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        $finished_cell = "<a class='js-finish tableLink' data-id='$row[id]' data-type='feed'>Finished</a>";
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td class='left'>$row[product_name]</th>
                                <td class='cen'>$row[purchase_date]</td>
                                <td class='cen'>$row[expiration_date]</td>
                                <td class='left'>$row[batch_number]</td>
                                <td>$finished_cell</td>
                            </tr>";
                    }

                    echo "</table>";
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Finshed feed card ------------------------------------------------
            public function finishedFeedCard($site_data, $year){

                $this -> connect();
                    $query = "  SELECT *
                                FROM feed
                                WHERE finished_date IS NOT null AND YEAR(purchase_date) = :year
                                ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':year', $year);
                    $sql -> execute();

                    echo "<table class='sortable'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Batch number</th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td class='left'>$row[product_name]</th>
                                <td class='cen'>$row[purchase_date]</td>
                                <td class='cen'>$row[expiration_date]</td>
                                <td class='left'>$row[batch_number]</td>
                            </tr>";
                    }

                    echo "</table>";
                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Feed years -------------------------------------------------------
            public function getFeedYears(){

                $this -> connect();

                    $query = "SELECT DISTINCT YEAR(purchase_date) AS year
                              FROM feed
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

        // -- Feed card --------------------------------------------------------
            public function feedCard($site_data, $id, $returnType){

                $functions = new Functions();

                $this -> connect();
                    $query = "  SELECT feed.id AS feed_id, product_name, purchase_date, batch_number, expiration_date, finished_date,
                                       cost_per_item, quantity, feed_type, feed_target, feed.notes AS feed_notes, supplier.supplier_name AS supplier_name
                                FROM feed
                                INNER JOIN supplier ON supplier.id
                                WHERE feed.id = :id AND supplier = supplier.id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $row = $sql -> fetch();

                $purchase_date = $functions -> dateFormat($row['purchase_date']);
                $product_name = $row['product_name'];
                $batch_number = $row['batch_number'];
                $expiration_date = $functions -> dateFormat($row['expiration_date']);
                $finished_date = $functions -> dateFormat($row['finished_date']);
                $supplier = $row['supplier_name'];
                $cost_per_item = $functions -> currencyFormat($row['cost_per_item']);
                $quantity = $row['quantity'];
                $feed_type = $row['feed_type'];
                $feed_target = $row['feed_target'];
                $notes = $row['feed_notes'];

                $data  = '';
                $data .= "<p class='controls'>";
                    $data .= "<a href='$site_data[site_root]/feed' class='back'>Back to feed</a>";
                    $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='feed' data-form='edit_feed'>Edit feed</a>";
                $data .= "</p>";
                $data .= "<div class='card feedCard'>";
                $data .= "  <h2>Feed details</h2>";
                $data .= "  <div class='col_2'>";
                $data .= "      <div>";
                $data .= "          <p><label>Product name:</label>$product_name</p>";
                $data .= "          <p><label>Source</label>$supplier</p>";
                $data .= "          <p><label>Purchase date:</label>$purchase_date</p>";
                $data .= "          <p><label>Expiration date</label>$expiration_date</p>";
                $data .= "          <p><label>Finished date</label>$finished_date</p>";
                $data .= "      </div>";
                $data .= "      <div>";
                $data .= "          <p><label>Batch number</label>$batch_number</p>";
                $data .= "          <p><label>Cost per item</label>$cost_per_item</p>";
                $data .= "          <p><label>Quantity</label>$quantity</p>";
                $data .= "          <p><label>Feed type</label>$feed_type</p>";
                $data .= "          <p><label>Feed target</label>$feed_target</p>";
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

            }
        // ---------------------------------------------------------------------

        // -- Add feed form ----------------------------------------------------
            public function form_addFeed(){
                $generic = new Generic();
                $form_element = new FormElements();
                $supplier_list =  $generic -> getSuppliersList('','');
                echo "<div class='form_container add_feed form_hide'>";
                    echo "<h3>Add feed</h3>";
                    echo "<form name='add_feed' class='col_2 js_form' data-action='add_feed'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('product_name', 'Product name', true, 'required', 'Please enter a product name');
                            $form_element -> select('supplier', 'Supplier', true, 'required', 'Please select a supplier', $supplier_list);
                            $form_element -> date('purchase_date', 'Purchase date', false, '', '');
                            $form_element -> date('expiration_date', 'Expiration date', false, '', '');
                            $form_element -> date('finished_date', 'Finished date', false, '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> text('batch_number', 'Batch number', false, '', '');
                            $form_element -> text('cost_per_item', 'Cost per item', false, '', '');
                            $form_element -> text('quantity', 'Quantity', false, '', '');
                            $form_element -> text('feed_type', 'Feed type', false, '', '');
                            $form_element -> text('feed_target', 'Feed target', false, '', '');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> submit('Add feed');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Add feed ---------------------------------------------------------
            public function sql_addFeed($form_data){

                $generic = new Generic();

                $product_name = $form_data[0]['value'];
                $supplier = $form_data[1]['value'];
                $purchase_date = $form_data[2]['value'] ? $form_data[2]['value'] : null;
                $expiration_date = $form_data[3]['value'] ? $form_data[3]['value'] : null;
                $finished_date = $form_data[4]['value'] ? $form_data[4]['value'] : null;
                $batch_number = $form_data[5]['value'];
                $cost_per_item = $form_data[6]['value'];
                $quantity = $form_data[7]['value'];
                $feed_type = $form_data[8]['value'];
                $feed_target = $form_data[9]['value'];

                $this -> connect();

                    $query = "  INSERT INTO feed (product_name, supplier, purchase_date, expiration_date, finished_date, batch_number, cost_per_item, quantity, feed_type, feed_target)
                                VALUES (:product_name, :supplier, :purchase_date, :expiration_date, :finished_date, :batch_number, :cost_per_item, :quantity, :feed_type, :feed_target)";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':product_name', $product_name);
                    $sql -> bindParam(':supplier', $supplier);
                    $sql -> bindParam(':purchase_date', $purchase_date);
                    $sql -> bindParam(':expiration_date', $expiration_date);
                    $sql -> bindParam(':finished_date', $finished_date);
                    $sql -> bindParam(':batch_number', $batch_number);
                    $sql -> bindParam(':cost_per_item', $cost_per_item);
                    $sql -> bindParam(':quantity', $quantity);
                    $sql -> bindParam(':feed_type', $feed_type);
                    $sql -> bindParam(':feed_target', $feed_target);
                    $sql -> execute();

                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'feedAdded';
                    $output -> product_name = $product_name;
                    $output -> purchase_date = $purchase_date;
                    $output -> expiration_date = $expiration_date;
                    $output -> batch_number = $batch_number;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Mark feed finished -----------------------------------------------
            public function sql_markFeedFinished($form_data){

                $id = $form_data[0]['value'];

                $this -> connect();
                    $query = "UPDATE feed SET finished_date = now() WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'feedFinished';
                    $output -> id = $id;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Edit feed form ----------------------------------------------------
            public function form_editFeed(){
                $generic = new Generic();
                $form_element = new FormElements();
                $supplier_list =  $generic -> getSuppliersList('','');
                echo "<div class='form_container edit_feed form_hide'>";
                    echo "<h3>Add feed</h3>";
                    echo "<form name='edit_feed' class='col_2 js_form' data-action='edit_feed'>";
                        echo "<div>";
                            $form_element -> required();
                            $form_element -> text('product_name', 'Product name', true, 'required', 'Please enter a product name');
                            $form_element -> select('supplier', 'Supplier', true, 'required', 'Please select a supplier', $supplier_list);
                            $form_element -> date('purchase_date', 'Purchase date', false, '', '');
                            $form_element -> date('expiration_date', 'Expiration date', false, '', '');
                            $form_element -> date('finished_date', 'Finished date', false, '', '');
                        echo "</div>";
                        echo "<div>";
                            echo "<p class='form_blank'></p>";
                            $form_element -> text('batch_number', 'Batch number', false, '', '');
                            $form_element -> text('cost_per_item', 'Cost per item', false, '', '');
                            $form_element -> text('quantity', 'Quantity', false, '', '');
                            $form_element -> text('feed_type', 'Feed type', false, '', '');
                            $form_element -> text('feed_target', 'Feed target', false, '', '');
                            $form_element -> hidden('id');
                        echo "</div>";
                        echo "<div class='fullWidth'>";
                            $form_element -> submit('Edit feed');
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            }
        // ---------------------------------------------------------------------

        // -- Get feed ---------------------------------------------------------
            public function sql_getFeed($id){

                $this -> connect();

                    $query = "SELECT * FROM feed WHERE id = :id";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> execute();
                    $output = new stdClass();
                    if($row = $sql -> fetch(PDO::FETCH_NAMED)){
                        $output -> id = $id;
                        $output -> product_name = $row['product_name'];
                        $output -> supplier = $row['supplier'];
                        $output -> purchase_date = $row['purchase_date'];
                        $output -> expiration_date = $row['expiration_date'];
                        $output -> finished_date = $row['finished_date'];
                        $output -> batch_number = $row['batch_number'];
                        $output -> cost_per_item = $row['cost_per_item'];
                        $output -> quantity = $row['quantity'];
                        $output -> feed_type = $row['feed_type'];
                        $output -> feed_target = $row['feed_target'];
                        $output -> context = 'editFeed';
                    }
                    echo json_encode($output);

                $this -> disconnect();

            }
        // ---------------------------------------------------------------------

        // -- Edit feed --------------------------------------------------------
            public function sql_editFeed($form_data){

                $product_name = $form_data[0]['value'];
                $supplier = $form_data[1]['value'];
                $purchase_date = $form_data[2]['value'] ? $form_data[2]['value'] : null;
                $expiration_date = $form_data[3]['value'] ? $form_data[3]['value'] : null;
                $finished_date = $form_data[4]['value'] ? $form_data[4]['value'] : null;
                $batch_number = $form_data[5]['value'];
                $cost_per_item = $form_data[6]['value'];
                $quantity = $form_data[7]['value'];
                $feed_type = $form_data[8]['value'];
                $feed_target = $form_data[9]['value'];
                $id = $form_data[10]['value'];

                $this -> connect();

                    $query = "  UPDATE feed
                                SET product_name = :product_name,
                                    supplier = :supplier,
                                    purchase_date = :purchase_date,
                                    expiration_date = :expiration_date,
                                    finished_date = :finished_date,
                                    batch_number = :batch_number,
                                    cost_per_item = :cost_per_item,
                                    quantity = :quantity,
                                    feed_type = :feed_type,
                                    feed_target = :feed_target
                                WHERE id = :id";

                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':id', $id);
                    $sql -> bindParam(':product_name', $product_name);
                    $sql -> bindParam(':supplier', $supplier);
                    $sql -> bindParam(':purchase_date', $purchase_date);
                    $sql -> bindParam(':expiration_date', $expiration_date);
                    $sql -> bindParam(':finished_date', $finished_date);
                    $sql -> bindParam(':batch_number', $batch_number);
                    $sql -> bindParam(':cost_per_item', $cost_per_item);
                    $sql -> bindParam(':quantity', $quantity);
                    $sql -> bindParam(':feed_type', $feed_type);
                    $sql -> bindParam(':feed_target', $feed_target);
                    $sql -> execute();

                $this -> disconnect();

                $output = new stdClass();
                    $output -> action = 'feedEdited';
                    $output -> id = $id;
                    $output -> product_name = $product_name;
                    $output -> purchase_date = $purchase_date;
                    $output -> expiration_date = $expiration_date;
                    $output -> batch_number = $batch_number;
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

    }

?>
