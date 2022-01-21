<?php
    include('partials/menu.php')
?>

<div class="main-content">
    <div class="wrapper">

        <h1>Update Category</h1>

        <br><br>

        <?php

            //Check whether the id is set or not
            if(isset($_GET['id']))
            {
                //Get the ID and all other detail
                $id = $_GET['id'];
                //create SQL Query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id='$id'";

                $res = mysqli_query($conn, $sql);

                //Coubt the Rows to check whether the id is valid or not.
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];   
                }
                else
                {
                    //Redirect 
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="title" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                        if($current_image != "")
                        {
                            //Display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image ?>" width="150px">
                            <?php
                        }
                        else
                        {
                            //Display message
                            echo "<div class='error'>Image not add.</div>";
                        }        
                        
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes

                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes

                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="submit" name="submit" value="Update category" class="btn-secondary">
                </td>
                
            </tr>
        </table>
      </form>
      <?php
         if(isset($_POST['submit']))
         {
            //1. Get All the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2.Updating New Image if selected
            if(isset($_FILES['image']['name']))
            {
                //Get the image detail
                $image_name = $_FILES['image']['name'];

                if($image_name != "")
                {
                    //Image avilable
                    
                    // get the extendsion of our image (jpg, png, gif, etc) e.g. "food.jpg"
                     $ext = end(explode('.', $image_name));

                    //Rename the image
                     $image_name = "Food_Category_".rand(000, 999).'.'.$ext;


                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    // check whether the image is uploaded or not
                    // and if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        // Stop the process
                        die();

                    }

                    // Remove the current image
                    if($current_image!="")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);
    
                        //Check whether the image is remove or not
                        // If failed to remove then display message and stop  the procces
                        if($remove == false)
                        {
                            //Failed to remove 
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('locatio:'.SITEURL.'admin/manage-category.php');
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                //
                $image_name = $current_image;
            }

            //3. Update the database
            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id='$id'
            ";

            $res2 = mysqli_query($conn, $sql2);


            //4. Redirect to manage category with message
            if($res2==true)
            {
                //Category uodate
                $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
                header('location:'.SITEURL."admin/manage-category.php");             
            } 
            else
            {
                //Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to update category</div>";
                header('location:'.SITEURL."admin/manage-category.php"); 
            }

         }                  

      ?>
        
    </div>     
</div>
    
<?php
    include('partials/footer.php')
?>