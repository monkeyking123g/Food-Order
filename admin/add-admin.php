<?php include("partials/menu.php"); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])) //Checking whether session is set of not
            {
                echo $_SESSION['add']; //display the session message if set
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>


<?php include('partials/footer.php') ?>

<?php
    
    //Process the Value from form and Save it in Database
    //Check whether thr submit button is clicked or not

    if (isset($_POST['submit']))
    {
        // Button Clicked
       // echo "Button clicked";

       //Get the Data from form
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];
       $password = md5($_POST['password']); //password nascosta con MD5

       //2. SQL Query to Save the date into database
       $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
       ";
        //3. Executing Query  and Saving Data info Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        //4. Check whether the (Query is Executed) date is inserted or not and display app appropriate message
        if($res==TRUE)
        {
           //data Inserted 
           //echo "Data Inserted";
           //Create a Session Variable to Display Message
           $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
           //Redirect Page to Add Admin
           header("location:".SITEURL."admin/manage-admin.php");

        }
        else
        {
            //Falited to Insert data
            //echo "Data not Inserted";
        }

    }
    
     

?>