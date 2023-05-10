<?php

include 'config.php';

if (isset($_GET['id'])) {
    $aip = $_GET['id'];
    $sql = "update jobsapplied set status='Accepted' where id='$aip';";
    $result = $conn->query($sql);
    header('location: viewApplicants.php?msg=accepted');
} else {
    header('location: viewApplicants.php?msg=error');
}
die();
?>