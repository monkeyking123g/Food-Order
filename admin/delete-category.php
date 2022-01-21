<?php
    // include constanrs file
    include('../config/constants.php');

    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != "")
        {
            //Image is availbal. So remove it
            $path = "../images/category/".$image_name;
            
            $remove = unlink($path);

            //If failed to remove then add an error message stop the process
            if($remove==false)
            {
                //set the session mesage
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
                die();

            }

        }

        //Delete data from database
        $sql = "DELETE FROM tbl_category WHERE id='$id'";
        
        //executed the query
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            //Set sucess message an redirect
            $_SESSION['delete'] = "<div class='success'>Category deleted successdully</div>";
            
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Set faild message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete category</div>";
            
            header('location:'.SITEURL.'admin/manage-category.php');

        }
        //redirect to  category pages with message


    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');

    }


?>