<?php

include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $eid = $_SESSION['id'];
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "delete from jobsapplied where sid=$eid";
    
    if ($conn->query($sql) === TRUE) {
       
           header('location: applicationStatus.php');
       
    }else{
        echo "Error Deleting Post";
    }
}

?>