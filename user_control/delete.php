<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isDelete = $userAuth->checkDeletePermission("5");

if (!$isDelete) {
  header("Location: ../pages/user.php");
  exit();
}

$id = $_GET["id"];
$sql = "DELETE FROM user WHERE id=$id";

$result = $conn->query($sql);

if ($result) {
  header("Location: ../pages/user.php");
}

$conn->close();
