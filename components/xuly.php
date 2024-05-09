<?php
require_once("db_connect.php");
$conn = new Database();


if(isset($GET['cartID'])){
    $st = $GET['cartID'];
    $cart=$GET['cartID'];
    $products = $conn->query("UPDATE order set status='.$st.'  where id='.$cart.'");
// header(loc);
    $conn->close();
}
?>