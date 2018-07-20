<?php session_start(); ?>
<?php 
    //Go back to Sign In page if no user is logged in
    if(!isset($_SESSION['user_id']))
    {
        header("Location: SignIn.php");
        exit();
    }
?>