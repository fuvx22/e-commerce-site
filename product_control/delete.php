<?php
require("../db_connect.php");
$conn = new Database();
$id = $_GET["id"];
$sql = "DELETE FROM product WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  session_start();
  $_SESSION["product_msg"] = "xóa sản phẩm thành công";
  header("Location: ../product.php");
}

$conn->close();
