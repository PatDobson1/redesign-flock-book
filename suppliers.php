<?php

    // -- Header ----------------------------------------------------
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        include_once 'includes/config.php';
        $layout = new Layout();
        $layout -> header($site_data);
    // --------------------------------------------------------------

    // -- Classes ---------------------------------------------------
        $supplier = new Supplier();
    // --------------------------------------------------------------

    // -- Content ---------------------------------------------------

        if( isset($_GET['id']) ){
            $supplier -> supplierCard($site_data, $_GET['id'], 'echo');
            $supplier -> form_editSupplier();
        }else{
            echo "<p class='add_holder'>";
                echo "<a class='js_showForm btn_island' data-form='add_supplier'>Add supplier</a>";
            echo "</p>";
            echo "<div class='card'>";
                echo "<h2>Suppliers</h2>";
                echo $supplier -> getAllSuppliers($site_data);
            echo "</div>";
            $supplier -> form_addSupplier();
        }

    // --------------------------------------------------------------

    // -- Footer ----------------------------------------------------
        $layout -> footer();
    // --------------------------------------------------------------

?>
