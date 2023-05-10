<?php

include 'config.php';

if (isset($_GET['id'])) {
    $aip = $_GET['id'];  //application id
    $sql = "update jobsapplied set status='Rejected' where id='$aip';";
    $result = $conn->query($sql);
    header('location: viewApplicants.php?msg=rejected');
} else {
    header('location: viewApplicants.php?msg=error');
}
die();
?>