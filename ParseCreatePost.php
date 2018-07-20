<?php
    include_once 'DBConnect.php';

    $title = $_POST['title'];
    $content = $_POST['content'];
    $subID = $_POST['sub'];
    $userID = $_POST['user_id'];

    if($subID != -1)
    {
        $query = "INSERT INTO post (title, content, date, user_id, sub_id) VALUES ('".$title."', '".$content."', now(), ".$userID.", ".$subID.")";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
      
    }
    header("Location:Main.php?sub=1");
?>