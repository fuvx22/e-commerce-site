<?php
require_once('../db_connect.php');
require_once('../utils/user-auth.php');
$conn = new Database();
$features_list = $conn->query("SELECT * FROM chucnang");

$userAuth = new userAuth($conn);
$read_permission_list = $userAuth->read_permission_list;

$conn->close();

function checkReadPermission($read_permission_list, $feature_id)
{
  if (in_array($feature_id, $read_permission_list)) {
    return ' ';
  } else {
    return 'hidden';
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/phu.css">
</head>

<body>
  <div class="side-menu d-flex flex-column">
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "1") ?>">
      <a href="../pages/order.php">Quản lý đơn hàng</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "2") ?>">
      <a href="../pages/product.php">Quản lý sản phẩm</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "3") ?>">
      <a href="../pages/receipt.php">Quản lý phiếu nhập</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "4") ?>">
      <a href="../pages/category.php">Quản lý danh mục & thể loại</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "5") ?>">
      <a href="../pages/user.php">Quản lý tài khoản</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "6") ?>">
      <a href="../pages/supplier.php">Quản lý nhà cung cấp</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "7") ?>">
      <a href="../pages/role.php">Quản lý quyền</a>
    </div>
    <div class="side-menu-item p-2 <?= checkReadPermission($read_permission_list, "8") ?>">
      <a href="../pages/payment.php">Quản lý thanh toán</a>
    </div>
  </div>
</body>

</html>