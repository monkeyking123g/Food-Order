<?php include('../config/constants.php');?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container mt-3" >
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                     echo $_SESSION['no-login-message'];
                     unset($_SESSION['no-login-message']);
                }
            ?>
            <br>
            <form action="" method="POST">
                <div class="mb-3 mt-3">
                    <label for="email">Username:</label>
                    <input type="text" class="form-control" placeholder="Enter username" name="username">
                </div>
                <div class="mb-3">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control"  placeholder="Enter password" name="password">
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
</html>
<?php
    // Check the button is clicked
    if(isset($_POST['submit']))
    {
        //Process for login
        //1. Get the data from login form
        $username = mysqli_real_escape_string($conn ,$_POST['username']);
        $password = md5($_POST['password']);

        //.2 Sql to check whether the user with username and password exists
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User available and login sucesss
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;  // to check whether the user is logged in or not and logout will unsert it  
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not available and login fail
             $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
             header('location:'.SITEURL.'admin/login.php');
        }

    }
?>