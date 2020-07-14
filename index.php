<h1>Flock Book</h1>

<p>Redesign site</p>

<?php

// -- Set up database connection ---------------------------------------
    $pdo = new PDO("mysql:host=localhost;dbname=fb_redesign", 'fb_redesign', 'Bjb29v&6__7][hGuye788');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $pdo = self::$conn -> prepare("SELECT * FROM sheep WHERE id = :id");
    $pdo = $pdo -> prepare("SELECT * FROM sheep");
    // $pdo -> bindParam(':id', $id);
    if( $pdo -> execute() ){
        if($results = $pdo -> fetch(PDO::FETCH_NAMED)){
            $page = $results['content'];
            return $page;
        }else{
            return "Page not found";
        }
    }

    $pdo = null;
// ---------------------------------------------------------------------

?>
