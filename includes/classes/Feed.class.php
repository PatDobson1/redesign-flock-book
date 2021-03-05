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

                    echo "<table class='sortable'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th class='delete_col no_sort'></th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td>$row[product_name]</th>
                                <td>$row[purchase_date]</td>
                                <td>$row[expiration_date]</td>
                                <td>$row[purchased_from]</td>
                                <td>$row[feed_target]</td>
                                <td></td>
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
                                WHERE finished_date IS NOT null AND
                                      YEAR(purchase_date) = :year
                                ORDER BY purchase_date DESC";
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':year', $year);
                    $sql -> execute();

                    echo "<table class='sortable'>
                            <tr>
                                <th>Name</th>
                                <th>Purchase date</th>
                                <th>Expiration date</th>
                                <th>Source</th>
                                <th>Target</th>
                            </tr>";
                    while( $row = $sql -> fetch() ){
                        echo "<tr data-id='$row[id]' class='js-view'>
                                <td>$row[product_name]</th>
                                <td>$row[purchase_date]</td>
                                <td>$row[expiration_date]</td>
                                <td>$row[purchased_from]</td>
                                <td>$row[feed_target]</td>
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
            public function feedCard($site_data, $id){

                $functions = new Functions();

                $this -> connect();
                    $query = "SELECT * FROM feed WHERE id = :id";
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
                $purchased_from = $row['purchased_from'];
                $cost_per_item = $functions -> currencyFormat($row['cost_per_item']);
                $quantity = $row['quantity'];
                $feed_type = $row['feed_type'];
                $feed_target = $row['feed_target'];
                $notes = $row['notes'];

                $data  = '';
                $data .= "<p class='controls'>";
                    $data .= "<a href='$site_data[site_root]/feed' class='back'>Back to feed</a>";
                    $data .= "<a class='right_aligned js_edit_btn' data-editid='$id' data-edittype='livestock' data-form='edit_livestock'>Edit livestock</a>";
                $data .= "</p>";
                $data .= "<div class='card animalCard'>";
                $data .= "  <h2>Feed details</h2>";
                $data .= "  <div class='col_2'>";
                $data .= "      <div>";
                $data .= "          <p><label>Product name:</label>$product_name</p>";
                $data .= "          <p><label>Source</label>$purchased_from</p>";
                $data .= "          <p><label>Purchase date:</label>$purchase_date</p>";
                $data .= "          <p><label>Expiration date</label>$expiration_date</p>";
                $data .= "          <p><label>Finished date</label>$finished_date</p>";
                $data .= "      </div>";
                $data .= "      <div>";
                $data .= "          <p><label>Batch number</label>$batch_number</p>";
                $data .= "          <p><label>Cost per item</label>$cost_per_item</p>";
                $data .= "          <p><label>Quanity</label>$quantity</p>";
                $data .= "          <p><label>Feed type</label>$feed_type</p>";
                $data .= "          <p><label>Feed target</label>$feed_target</p>";
                $data .= "      </div>";
                $data .= "  </div>";
                $data.= "   <div>";
                $data.= "       <p class='fullWidth'><label>Notes:</label>$row[notes]</p>";
                $data.= "   </div>";
                $data .= "</div>";

                echo $data;

            }
        // ---------------------------------------------------------------------

    }

?>
