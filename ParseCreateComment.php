<?php
    include_once 'DBConnect.php';

    $content = $_POST['content'];
    $userID = $_POST['user_id'];
    $postID = $_POST['post_id'];

    $query = "INSERT INTO comment (content, date, user_id, post_id) VALUES ('".$content."', now(), '".$userID."', ".$postID.")";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    header("Location:Post.php?post=".$postID."");
?>