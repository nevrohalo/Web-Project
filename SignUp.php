<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>UNYT Sign Up</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juxhin Abazi">
        <link rel="stylesheet" type="text/css" href="StyleSignUp.css">
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.validate.js"></script>
    </head>
    <body>
        <div class="signup-box">
            <img src="images/user_male.png" class="avatar">
            <h1>Sign Up</h1>
            <form action="" method="post">
                <p>Name: </p>
                <input type="text" name="name" placeholder="Enter Firstname and Lastname" minlength="3">
                <p>Username: </p>
                <input type="text" name="username" placeholder="Enter Username" minlength="8">
                <p>Password: </p>
                <input type="password" name="password" placeholder="Enter Password" minlength="8">
                <p>Confirm Password: </p>
                <input type="password" name="password-check" placeholder="Re-enter Password" minlength="3">
                <input type="submit" name="submit" value="Register">
            </form>
            <p id="simple">Already have an account? <a href="SignIn.php">Sign In.</a></p>
                
            <?php
                include_once "DBConnect.php";
                
                if(isset($_POST["submit"]))
                { 
                    if(!empty($_POST["name"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password-check"]))
                    {
                        $name = $_POST['name'];
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $password_check = $_POST['password-check'];
                        $isUnique = true;
                        
                        $query = "SELECT * FROM user";
                        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                        if (mysqli_num_rows($result) > 0) 
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                if($username === $row['username'])
                                    $isUnique = false;
                            }
                        }
                        
                        if($isUnique)
                        {
                            if($password === $password_check)
                            {
                                $query = "INSERT INTO user (name, username, password)
                                        VALUES ('".$name."', '".$username."', '".$password."')";

                                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                                header("Location:SignIn.php");
                                exit();
                            }
                            else
                            {
                                echo "The passwords don't match.";
                            }
                        }
                        else
                        {
                            echo "The username already exists.";
                        }
                    }
                    else 
                    {  
                        echo "You must fill all fields!";  
                    }
                }
            ?>
        </div>
    </body>
</html>