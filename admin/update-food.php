<?php include('partials/menu.php')?>

<?php
    //Check whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL qyery to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execurted the qyery
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on qyery executed 
        $row2 = mysqli_fetch_assoc($res2);

        // Get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //redirect
        header('location:'.SITEURL.'admin/manage-food.php');

    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title;?>">

                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description"  cols="30" rows="5"><?php echo $description;?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                     <?php
                        if($current_image == "")
                        {
                            //image not availabel
                            echo "<div class='error'>Image not available</div>";

                        }
                        else
                        {
                            //image  available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                            
                        }
                     ?>
                </td>
            </tr>

            <tr>
                <td>Select new image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        <?php
                            //Query to get active category
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Executed the Query
                            $res=mysqli_query($conn, $sql);
                            //Count rows
                            $count = mysqli_num_rows($res);

                            //Check wheter category aviable or not 
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category not available
                                echo "<option value='0'>Category not available</option>";
                            }

                        ?>
                    </select>    
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                <input  <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                <input  <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>"> 
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php
            if(isset($_POST['submit']))
            {
                //1. Get all the detail from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];


                //2. Upload the image if selected
                if(isset($_FILES['image']['name']))
                {
                    //Upload iamge
                    $image_name = $_FILES['image']['name']; // new image name

                    if($image_name!="")
                    {
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-name".rand(0000,9999).'.'.$ext; //rename image

                        //get the source path and destination path 
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name; //Destination path 

                        $upload = move_uploaded_file($src_path, $dest_path);

                        if($upload==false)
                        {
                            //failed to upload
                            $_SESSION['upload'] = "<div class='error'>failed to uoload new image.</div>";
                            header('location:'.SITEURL."admin/manage-food.php");
                            die();
                        }

                        //B. remove current image if available
                        if($current_image != "")
                        {
                            //Current image is available
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);
                            //Check whether the image is removed or not
                            if($remove==false)
                            {
                                //faile to remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove curremt image</div>";
                                header('loaction:'.SIETURL.'admin/manage-food.php');
                                die();


                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; // Defult image when image is not selected 
                    }
                }
                else
                {
                    $image_name = $current_image;

                }

                //4. Update the Food in Database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";
                //Execute the SQL query
                $res3 = mysqli_query($conn, $sql3);

                if($res3==true)
                {
                    //Query executed and food update
                    $_SESSION['update'] = "<div class='success'>Food update sucessfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            } 
        ?>
    </div>
</div>

<?php include('partials/footer.php')?>
