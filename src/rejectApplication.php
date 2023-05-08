<?php

include 'config.php';

if (isset($_GET['id'])) {
    $aip = $_GET['id'];  //application id
    $sql = "update jobsapplied set status='Rejected' where id='$aip';";
    $result = $conn->query($sql);
    $_SESSION['rejected'] = "rejected";
    header('location: viewApplicants');
} else {
    $_SESSION['error'] = "error";
    header('location: viewApplicants');
}
die();
?>