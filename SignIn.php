<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNYT Sign In</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juxhin Abazi">
        <link rel="stylesheet" type="text/css" href="StyleSignIn.css">        
    </head>
    <body>
        <div class="signin-box">
            <img src="images/user_male.png" class="avatar">
            <h1>Sign In</h1>
            <form action="" method="POST">
                <p>Username: </p>
                <input type="text" name="username" placeholder="Enter Username">
                <p>Password: </p>
                <input type="password" name="password" placeholder="Enter Password">
                <input type="submit" name="submit" value="Login">
            </form>
            <p id="simple">Don't have an account? <a href="SignUp.php">Sign Up.</a></p><br>
            
            <?php
                include_once "DBConnect.php";
                
                if(isset($_POST["submit"]))
                { 
                    if(!empty($_POST["username"]) && !empty($_POST["password"]))
                    {
                        if(isset($_POST['username']))
                        {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            $query = "SELECT * FROM user WHERE username='".$username."' AND password='".$password."'";
                            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                            if(mysqli_num_rows($result) == 1)
                            {
                                $row = mysqli_fetch_assoc($result);
                                $_SESSION['user_id'] = $row['user_id'];
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['description'] = $row['description'];
                                header("Location: Main.php?sub=1");
                                exit();
                            }
                            else
                            {
                                echo "Invalid Username or Password!";
                                exit();
                            }
                        }
                    }
                    else 
                    {  
                        echo "You must fill all the fields!";  
                    }
                }
            ?>
        </div>
    </body>
</html>