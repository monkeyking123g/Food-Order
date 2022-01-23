<?php
    // Start Session
    session_start();

    //Create Constants to Store Non Repeating Values
    define('SITEURL','https://food-order-php.000webhostapp.com/' );
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME','id18331501_dimaipatii');
    define('DB_PASSWORD', 'Ppm.YaGwg@D8Myx');
    define('DB_NAME', 'id18331501_foodorderphp');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); //database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //selecting Database

?>
