<?php
    include('../config/constants.php');
    //1. get thr ID of admin to be delete
    $id = $_GET['id'];

    //2. Create SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    
    //Executed the query
    $res = mysqli_query($conn, $sql);

    //Check whether the query executed successfully or not 
    if($res==true)
    {
        
        //Create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin deleted sucessfully</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');



    }
    else
    {
        $_SESSION['delete'] = "<div calss='error'>Failed to deleted admin. Try again later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. Redirect to manage admin page with message

?> 