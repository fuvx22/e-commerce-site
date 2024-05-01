<?php
require_once "../utils/user-auth.php";
require_once("../db_connect.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isDelete = $userAuth->checkDeletePermission("2");

if (!$isDelete) {
  header("Location: ../pages/product.php");
  exit();
}

$id = $_GET["id"];
$sql = "DELETE FROM product WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  session_start();
  $_SESSION["product_msg"] = "xóa sản phẩm thành công";
  header("Location: ../pages/product.php");
}

$conn->close();
