<h1>Flock Book</h1>

<p>Redesign site</p>

<?php

// -- Set up database connection ---------------------------------------
    $pdo = new PDO("mysql:host=localhost;dbname=fb_redesign", 'fb_redesign', 'Bjb29v&6__7][hGuye788');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $pdo = self::$conn -> prepare("SELECT * FROM sheep WHERE id = :id");
    $sql = $pdo -> prepare("SELECT * FROM sheep");
    // $pdo -> bindParam(':id', $id);
    $sql->execute();
    while( $row = $sql -> fetch() ){
            echo "<p>$row[uk_tag_no]</p>";
    }

    $pdo = null;
// ---------------------------------------------------------------------

?>
