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
  <link rel="stylesheet" href="../css/phu.css">
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>

<body>
  <div class="d-flex admin-menu">
    <div class="admin-menu-item">
      <a href="../pages/admin.php">
        <i class="fas fa-home"></i>
      </a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "1") ?>">
      <a href="../pages/order.php">đơn hàng</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "2") ?>">
      <a href="../pages/product.php">sản phẩm</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "3") ?>">
      <a href="../pages/receipt.php">phiếu nhập</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "4") ?>">
      <a href="../pages/category.php">danh mục & thể loại</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "5") ?>">
      <a href="../pages/user.php">tài khoản</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "6") ?>">
      <a href="../pages/supplier.php">nhà cung cấp</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "7") ?>">
      <a href="../pages/role.php">quyền</a>
    </div>
    <div class="admin-menu-item <?= checkReadPermission($read_permission_list, "8") ?>">
      <a href="../pages/payment.php">thanh toán</a>
    </div>
  </div>
</body>

</html>