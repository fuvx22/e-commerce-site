<?php
require_once('../db_connect.php');
require_once("../utils/user-auth.php");

$conn = new Database();

$userAuth = new userAuth($conn);
$isDelete = $userAuth->checkDeletePermission("7");

if (!$isDelete) {
  header("Location: ../pages/role.php");
  exit();
}

$idToDelete = $_GET['id'];

$sql = "DELETE FROM role WHERE id = $idToDelete";

$conn->query($sql);

$conn->close();

session_start();
$_SESSION["role_msg"] = "Xóa quyền thành công";
header("Location: ../pages/role.php");
exit();
