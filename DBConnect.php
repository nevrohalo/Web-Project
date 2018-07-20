<?php
    $server = "localhost";
    $username   = "root";
    $password   = "";
    $database = "forum";

    $connection = mysqli_connect($server, $username,  $password);
    mysqli_select_db($connection, $database);
?>