<?php
    //include constants part
    include('../config/constants.php');



    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Proces to delete
        //1. Get ID and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the image aviable
        if($image_name != "")
        {
            //Get the image path
            $path = "../images/food/".$image_name;
            
            //Remove image file from folder
            $remove = unlink($path);

            //Check whether the image is removed or not
            if($remove==false)
            {
                //Failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-food.php');
                die();

            }

        }

        //3.delete food from database
        $sql= "DELETE FROM tbl_food WHERE id=$id";
        //Execute the query
        $res=mysqli_query($conn, $sql);

        if($res==true)
        {
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('location:'.SITEURL."admin/manage-food.php");


        }
        else
        {
            //falided to delete message
            $_SESSION['delete'] = "<div class='error'>Failed to deleted food.</div>";
            header('location:'.SITEURL."admin/manage-food.php");
        }

    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthoraze'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }
?>