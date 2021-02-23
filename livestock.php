<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $livestock = new Livestock();
        $species = new Species();
        $breeds = new Breeds();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        // echo "<div class='col_2'>";
        //     echo "<div class='card'>";
        //         echo "<h2>Species</h2>";
        //         $species -> speciesCard(false);
        //     echo "</div>";
        //     echo "<div class='card'>";
        //         echo "<h2>Breeds</h2>";
        //         $breeds -> simpleBreedCard(false);
        //     echo "</div>";
        // echo "</div>";
        if( isset($_GET['id']) ){
            $livestock -> animalCard($site_data, $_GET['id']);
            $livestock -> siblingsCard($site_data, $_GET['id']);
            $livestock -> childrenCard($site_data, $_GET['id']);
            $livestock -> familyTree($site_data, $_GET['id']);
            $livestock -> diaryCard($site_data, $_GET['id']);
        }else{
            $livestock -> animalSearchCard($site_data);
            echo "<div class='card'>";
                echo "<h2>Livestock</h2>";
                $livestock -> liveStockCard(true);
            echo "</div>";
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
