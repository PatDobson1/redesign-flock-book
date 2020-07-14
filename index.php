<h1>Flock Book</h1>

<p>Redesign site</p>

<?php

// -- Set up database connection ---------------------------------------
    $pdo = new PDO("mysql:host=localhost;dbname=fb_redesign", 'fb_redesign', 'Bjb29v&6__7][hGuye788');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $pdo = self::$conn -> prepare("SELECT * FROM sheep WHERE id = :id");
    $sql = $pdo -> prepare("SELECT * FROM sheep");
    // $pdo -> bindParam(':id', $id);
    while( $row = $sql -> fetch() ){
            var_dump($row);
    }

    $pdo = null;
// ---------------------------------------------------------------------

?>
