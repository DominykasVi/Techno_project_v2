<?php 
// Check connection
// print_r($_REQUEST);
session_start(); 

if(isset($_REQUEST['back'])){
    $_SESSION['id'] = $_SESSION['guest_id'];
    $_SESSION['guest_id'] = -1;
    echo $_SESSION['guest_id'];
}

if(isset($_REQUEST['id'])){
    $_SESSION['guest_id'] = $_SESSION['id'];
    echo $_SESSION['guest_id'];
    $_SESSION['id'] = $_REQUEST['id'];
    echo $_SESSION['id'];
}
?>