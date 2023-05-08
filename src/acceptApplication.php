<?php

include 'config.php';

if (isset($_GET['id'])) {
    $aip = $_GET['id'];
    $sql = "update jobsapplied set status='Accepted' where id='$aip';";
    $result = $conn->query($sql);
    $_SESSION['accepted'] = "accepted";
    header('location: viewApplicants.php?msg=accepted');
} else {
    $_SESSION['error'] = "error";
    header('location: viewApplicants.php?msg=error');
}
die();
?>