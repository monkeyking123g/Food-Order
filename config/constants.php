<?php
    // Start Session
    session_start();

    //Create Constants to Store Non Repeating Values
<<<<<<< HEAD
    define('SITEURL','http://localhost/food-order/' );
    define('LOCALHOST', 'localhost');
=======
    define('SITEURL','https://food-order-projectt.herokuapp.com/' );
    define('LOCALHOST', 'heroku.com');
>>>>>>> 3be9228123f96bd788107fcadfbffe8edb5c67a7
    define('DB_USERNAME','root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); //database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //selecting Database

?>
