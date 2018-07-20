<?php
    $userID = $_POST['user_id'];
    
    header("Location:User.php?user_id=".$userID."&cat=1");
?>