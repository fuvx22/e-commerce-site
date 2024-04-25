<?php
require_once('../db_connect.php');

$conn = new Database();

$idToDelete = $_GET['id'];

$sql = "DELETE FROM role WHERE id = $idToDelete";

$conn->query($sql);

$conn->close();

session_start();
$_SESSION["role_msg"] = "Xóa quyền thành công";
header("Location: ../pages/role.php");
exit();
