<?php
    include_once 'DBConnect.php';

    $title = $_POST['title'];
    $description = $_POST['description'];
    $userID = $_POST['user_id'];

    $query = "INSERT INTO sub (title, description, user_id) VALUES ('".$title."', '".$description."', ".$userID.")";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    header("Location:Main.php?sub=1");
?>