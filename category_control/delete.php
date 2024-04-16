<?php
require("../db_connect.php");
$conn = new Database();
$id = $_GET["id"];
$type = $_GET["type"];

$sql = "DELETE FROM $type WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  session_start();
  $_SESSION["subcategory_msg"] = "xóa " . $type == "category" ? "danh mục" : "thể loại" . " sản phẩm thành công";
  header("Location: ../pages/category.php");
}

// $conn->close();
echo $sql;
