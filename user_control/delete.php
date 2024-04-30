<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
$conn = new Database();
$id = $_GET["id"];
$sql = "DELETE FROM user WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  session_start();
  $_SESSION["product_msg"] = "xóa sản phẩm thành công";
  header("Location: ../user.php");
}

$conn->close();
