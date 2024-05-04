<?php 
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    session_start();
    if(isset ($_SESSION['userData'])){
        unset($_SESSION['userData']);
    }
    session_destroy();
    header("Location:../index.php");
    exit();
}
?>