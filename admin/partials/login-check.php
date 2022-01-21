<?php
    //Authorization - access control
    // check whether the user is logged in or not !
    if(!isset($_SESSION['user']))// If user session si not set
    {
        //User is not logged in 
        //Redirect to login page whit message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access admin panel</div>";
        
        header('location:'.SITEURL.'admin/login.php');
    }

?>