<?php

include 'config.php';
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $pid = $_GET['id'];
    $sid = $_SESSION['id'];

    $sql = "select * from jobsapplied where pid='$pid' and sid='$sid';";
    $result = $conn->query($sql);
    $count = $result->num_rows;
    if ($count > 0) {
        header("location: findjob.php");
        die();
    }

    $sql = "INSERT INTO `jobsapplied` "
        . "(`id`, `date`, `pid`, `sid`, `status`) "
        . "VALUES (NULL, CURRENT_DATE(), '$pid', '$sid', 'Applied');";
    if ($conn->query($sql) === TRUE) {
        header("location: findjob.php");
    }
}
else{
    $_SESSION['redirect'] = "applyJob";
    header("location: emplogin.php");
}