<?php

    class Search extends Db{

        // -- Get breeds based on id -------------------------------------------
            public function livestock_freeText($form_data){

                $free_text = $form_data[0]['value'];

                $query = "  SELECT livestock.livestock_name, livestock.uk_tag_no, livestock.date_of_birth, livestock.id,
                                   breed.breed_name AS breed, species.species AS species
                            FROM livestock
                            INNER JOIN species ON species.id = livestock.species
                            INNER JOIN breed ON breed.id = livestock.breed
                            WHERE (livestock.livestock_name LIKE concat('%', :free_text, '%') OR livestock.uk_tag_no LIKE concat('%', :free_text, '%') )
                            AND deleted = 0";
                $this -> connect();
                    $sql = self::$conn -> prepare($query);
                    $sql -> bindParam(':free_text', $free_text);
                    $sql -> execute();
                    $count = $sql -> rowCount();
                $this -> disconnect();

                $output = new stdClass();
                $output -> action = 'livestockFreeTextSearch';
                $output -> html = $this -> createResults_livestock($sql, $count, $free_text);
                echo json_encode($output);

            }
        // ---------------------------------------------------------------------

        // -- Create livestock results -----------------------------------------
            private function createResults_livestock($sql, $count, $free_text){

                $plural = $count === 1 ? '' : 's';
                $html = '<h2>Search results</h2>';
                if($count){
                    $html .= "<p>You searched for '<strong>$free_text</strong>' - $count result$plural returned</p>";
                    $html .= "  <table class='sortable'>
                                <tr>
                                    <th>Tag No.</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Species</th>
                                    <th>Breed</th>
                                    <th class='no_sort'></th>
                                </tr>";
                    while( $row = $sql -> fetch() ){
                        $replace = '<strong>' . $free_text . '</strong>';
                        // -- String highlighting - replaces upper/lower case --
                            $livestock_name_replace = '<strong>' . substr($row['livestock_name'], stripos($row['livestock_name'], $free_text), strlen($free_text)) . '</strong>';
                            $livestock_name = str_ireplace( $free_text, $livestock_name_replace, $row['livestock_name']  );
                            $tag_name_replace = '<strong>' . substr($row['uk_tag_no'], stripos($row['uk_tag_no'], $free_text), strlen($free_text)) . '</strong>';
                            $uk_tag_no = str_ireplace( $free_text, $tag_name_replace, $row['uk_tag_no']  );
                        // -----------------------------------------------------
                        $html .= "  <tr data-id='$row[id]' class='js-view'>
                                    <td class='left'>$uk_tag_no</td>
                                    <td class='left'>$livestock_name</td>
                                    <td class='cen'>$row[date_of_birth]</td>
                                    <td class='left'>$row[species]</td>
                                    <td class='left'>$row[breed]</td>
                                    <td><span class='icon icon_quickView js-quickView' data-id='$row[id]'></span></td>
                                </tr>";
                    }
                    $html .= "</table>";
                }else{
                    $html .= "<p class='none'>You searched for '<strong>$free_text</strong>' - No results returned</p>";
                }
                return $html;

            }
        // ---------------------------------------------------------------------
    }

?>
