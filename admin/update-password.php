<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Old Password"> 
                    </td>
                    
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm password" >
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
                
            </table> 

        </form> 
    </div>
</div>
<?php
    // check wheter the submit button is clicked
    if(isset($_POST['submit']))
    {
        //1. Get the data whether the user with current ID and password exists
        $id=$_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2.
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
        
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $count = mysqli_num_rows($res);

            if($count==1)
            {
               //Check whether the new password and confirm match 
               if($new_password==$confirm_password)
               {
                   //Update the password
                   $sql2 = "UPDATE tbl_admin SET
                        password = '$new_password'
                        WHERE id='$id'
                   ";
                   //Execute the query
                   $res2 = mysqli_query($conn, $sql2);

                   //chech wheteher the query executed or not 
                   if($res2==true)
                   {
                       //Display succes message
                       $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully.</div>";
                       header('location:'.SITEURL.'admin/manage-admin.php');
                   }
                   else
                   {
                       //Dispaly error message
                       $_SESSION['change-pwd'] = "<div class='error'>Fallid ti change password.</div>";
                       header('location:'.SITEURL.'admin/manage-admin.php');

                   }
               }
               else
               {
                   //Redirect to manage admin page with error message
                   $_SESSION['pwd-not-match'] = "<div class='error'>Password did not patch.</div>";
                   header('location:'.SITEURL.'admin/manage-admin.php');

               }


            }
            else
            {
                //user does not exists set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not found.</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }

        }
    }

?>

<?php include('partials/footer.php');?>