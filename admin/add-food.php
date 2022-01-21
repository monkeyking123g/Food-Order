<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" id="">
                        
                        <?php
                            //Create PHP code  to display categories from database
                            //1. Create SQL to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            $res = mysqli_query($conn, $sql);

                            //Count Rows to chech whether we have category
                            $count = mysqli_num_rows($res);

                            if($count>0)
                            {
                                //We heve categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>   
                                    <?php
                                }
                            }
                            else
                            {
                                //We do not heve category
                                ?>
                                <option value="0">No category Found</option>
                                <?php
                            }

                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" value="Yes" name="featured">Yes
                        <input type="radio" value="No" name="featured">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" value="Yes" name="active">Yes
                        <input type="radio" value="No" name="active">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <?php
            // Check whether the button is clicked or mot
            if(isset($_POST['submit']))
            {
                //Add the Food Database

                //1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; // setting the default value
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];

                }
                else
                {
                    $active = "No"; // setting the default value 
                }

                         //2. Upload the Image if selected 
                if(isset($_FILES['image']['name']))
                {
                   //Get the details of the selected image
                   $image_name = $_FILES['image']['name'];
                   
                   //Check whether the Image is selected or not an upload if selected
                   if($image_name!="")
                   {
                       // Image is selected
                       //A. Rename the Image
                       $ext = end(explode('.', $image_name));

                       //Create new name for image
                       $image_name = "Food-Name-".rand(0000,9999).".".$ext; // New image name

                       //B. Upload the Image
                       //Get the  scr path and destination path

                       //Source path is the current location of the image
                       $src = $_FILES['image']['tmp_name'];

                       //Destination path for the image to be uploaded
                       $dst = "../images/food/".$image_name;

                       //Finally Uppload the food image
                       $upload = move_uploaded_file($src, $dst);

                       //Check whether image uploaded of not 
                       if($upload==false)
                       {
                           //failed to Upload the image
                           $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                           
                           //Redirect
                           header('location:'.SITEURL.'admin/add-food.php');
                           die();
                        }
                    }
                }
                else
                {
                    $image_name = "";  // Setting defult valueas as blank
                }


                //3. Insert Info Database
                $sql2 = "INSERT INTO tbl_food SET
                   title ='$title',
                   description = '$description',
                   price = $price,
                   image_name = '$image_name',
                   category_id = $category,
                   featured = '$featured',
                   active = '$active' 
                ";

                //execute the Query
                $res2 = mysqli_query($conn, $sql2);

                if($res2 == true)
                {
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food add successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                
                //4. Redirect with message to manage food page

                
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>