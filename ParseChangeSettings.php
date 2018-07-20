<?php
    include_once "DBConnect.php";

    $userID = $_POST['user_id'];
    
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $rePassword = $_POST['rePassword'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $madeChanges = false;

    $query = "SELECT * FROM user WHERE user_id = ".$userID."";
    $result = mysqli_fetch_assoc(mysqli_query($connection, $query)) or die(mysqli_error($connection));
        
    //Changing the Password
    if($oldPassword != "" && $newPassword != "" && $rePassword != "" )
    {
        if($oldPassword === $result['password'])
        {
            if($newPassword === $rePassword)
            {
                $madeChanges = true;
                $passwordQuery = "UPDATE `user` SET `password` = \"".$newPassword."\" WHERE user_id = ".$userID."";
                $result = mysqli_query($connection, $passwordQuery) or die(mysqli_error($connection));
            }
            else
            {
                header("Location:User.php?user_id=".$userID."&cat=3&err=1");
            }
        }
        else
        {
            header("Location:User.php?user_id=".$userID."&cat=3&err=2");
        }
    }
    else if($oldPassword == "" && $newPassword == "" && $rePassword == "" )
    {
        //do nothing
    }
    else
    {
        header("Location:User.php?user_id=".$userID."&cat=3&err=3");
    }

    //Changing the name
    if($name != "")
    {
        $madeChanges = true;
        $nameQuery = "UPDATE `user` SET `name` = \"".$name."\" WHERE user_id = ".$userID."";
        $result = mysqli_query($connection, $nameQuery) or die(mysqli_error($connection));
    }

    //Changing the description
    if($description != "")
    {
        $madeChanges = true;
        $descriptionQuery = "UPDATE `user` SET `description` = \"".$description."\" WHERE user_id = ".$userID."";
        $result = mysqli_query($connection, $descriptionQuery) or die(mysqli_error($connection));
    }

    //Deleting the account
    if(isset($_POST['delete']) && $_POST['delete'] == 'Yes')
    {
        $madeChanges = true;
        $deleteQuery = "DELETE IGNORE FROM `user` WHERE user_id = ".$userID."";
        $result = mysqli_query($connection, $deleteQuery) or die(mysqli_error($connection));

        session_start();
        session_destroy();
        mysqli_close($connection);
        header("Location:SignIn.php");
    }

    mysqli_close($connection);

    if($madeChanges)
    {
        header("Location:User.php?user_id=".$userID."&cat=3");
    }
?>