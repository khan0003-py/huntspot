<?php

include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $eid = $_SESSION['id'];
}

if(isset($_GET['id'])){
    include 'connect.php';
    $id = $_GET['id'];
    $sql = "delete from post where id=$id";
    
    if ($conn->query($sql) === TRUE) {
       
           header('location: employerAccount.php');
       
    }else{
        echo "Error Deleting Post";
    }
}

?>