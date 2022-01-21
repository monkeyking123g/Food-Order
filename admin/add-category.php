<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }    
        ?>
        <br>
        <!--Add category form start -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category title">
                    </td>
                </tr> 
                <tr>
                     <td>Select Image: </td>
                     <td>
                         <input type="file" name="image"> 
                     </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Add category" class="btn-secondary" name="submit"> 
                    </td>
                </tr>
            </table>
        </form>  

        <!--Add category form ends -->

        <?php
            //Check whether the submit button is clicked or not 
            if(isset($_POST['submit']))
            {
                echo "Cliked";
                //1. Get the value from category form
                $title = $_POST['title'];

                //For radio input , we ned to check whether the button  is sected or not
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the Default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];

                }
                else
                {
                    $active = "No";

                }

                if(isset($_FILES['image']['name']))
                {
                    //Upload the Images
                    $image_name=$_FILES['image']['name'];

                    //Upload image only if image is selected
                    if($image_name!="")
                    {

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
                            header('location:'.SITEURL.'admin/add-category.php');
                            // Stop the process
                            die();

                        }
                    }

                }
                else
                {
                    //Don't upload image and set the image_name value as blank
                    $image_name="";
                } 

                //.2 Create SQL query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";
                
                //3. Executed the query and save
                $res = mysqli_query($conn, $sql);

                //. Check whether the query executed or not and date added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category added successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['add'] = "<div class='error'>Failed to add category</div>";

                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            } 
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>