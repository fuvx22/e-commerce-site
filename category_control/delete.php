<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isDelete = $userAuth->checkDeletePermission("4");

if (!$isDelete) {
  header("Location: ../pages/category.php");
  exit();
}

$id = $_GET["id"];
$type = $_GET["type"];

$sql = "DELETE FROM $type WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  session_start();
  $_SESSION["subcategory_msg"] = "Xóa " . ($type == "category" ? "danh mục" : "thể loại") . " sản phẩm thành công";
  header("Location: ../pages/category.php");
}

// $conn->close();
echo $sql;
