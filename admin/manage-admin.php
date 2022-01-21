<?php include("partials/menu.php"); ?>

        <!-- Contatti Sezione Sart -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br />

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Display messag e
                        unset($_SESSION['add']); //Removing message
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }
                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }
                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                ?>
                <br><br><br>
                <!-- Button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admon</a>

                <br /><br /><br />
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //Query to get all Admin
                        $sql = "SELECT * FROM tbl_admin";
                        //Execute the query
                        $res = mysqli_query($conn, $sql);
                        // Check whether the query is ecuted of not
                        if($res==TRUE)
                        {
                            // Count rows to check whether we data in database or not
                            $count = mysqli_num_rows($res);//Function to get all the rows in database

                            $sn=1; //createa variable and assing the value

                            //check the num in rows
                            if($count>0)
                            {
                                //We have data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //Using While loop to all thr data from database.
                                    //And while loop will run as we heve data in database.
                                    
                                    //Get individal data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //Display the values in our table
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                          <td><?php echo $full_name; ?></td>
                                          <td><?php echo $username; ?></td>
                                          <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id?>" class="btn-danger">Delete Admin</a>  
                                        </td>
                                    </tr>

                                    
                                    <?php


                                }

                            } 
                        }

                    ?>
                </table>
            </div>
        </div>
        <!-- Contatti Sezione Ends -->

<?php include("partials/footer.php"); ?>  