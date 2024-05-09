<?php 
 require_once("../db_connect.php");
 require_once("../utils/user-auth.php");
 require_once("../model/orderModel.php");
 session_start();
 $conn = new Database();
 
 $userAuth = new userAuth($conn);
 $userAuth->checkReadPermission("2");
 
 $isCreate = $userAuth->checkCreatePermission("2");
 $isUpdate = $userAuth->checkUpdatePermission("2");
 $isDelete = $userAuth->checkDeletePermission("2");
 if(isset($_SESSION['startDate']) && isset($_SESSION['endDate'])){
     $startDate = $_SESSION['startDate'];
     $endDate = $_SESSION['endDate'];
     unset($_SESSION['startDate']);
    unset($_SESSION['endDate']);
 }
 $orders = isset($_SESSION['filtered_orders']) ? $_SESSION['filtered_orders'] : orderModel::getOrder();
 $conn->close();
?>
<?php 
    // Unset the session variable after using it
    if(isset($_SESSION['filtered_orders'])) {
        unset($_SESSION['filtered_orders']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <script defer src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include("../components/admin-menu.php") ?>
<div class="container">
    <div class="col mt-2 ms-2">
        <h3>Quản Lí Đơn Hàng</h3>
    </div>
    <div class="container mt-3 d-flex justify-content-center ">
    <form method="post" action="/e-commerce-site/controller/searchOrderedDateController.php">
        <div class="row">
            <p class="fw-bold fs-4">Lọc Theo Ngày Đặt Hàng</p>
            <div class="col">
                <div class="mb-3">
                    <label for="startDate"  class="form-label">Từ Ngày</label>
                    <input type="date" value="<?php echo $startDate; ?>" name="startDate" class="form-control" id="startDate">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="endDate" class="form-label">Đến Ngày</label>
                    <input type="date" value="<?php echo $endDate; ?>" name="endDate" class="form-control" id="endDate">
                </div>
            </div>
            <div class="col align-self-end mb-3">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>
    </div>
    <?php if(is_array($orders)): ?>
    <?php foreach($orders as $order): ?>
        <div class=" mb-3 border  rounded list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div>
                    <p>Mã đơn hàng: <strong><?php echo $order['id']; ?></strong> </p>
                    <p>Ngày đặt: <strong><?php 
                    $date = DateTime::createFromFormat('Y-m-d', $order['enrollDate']);
                    echo $date->format('d/m/Y'); 
                    ?></strong> </p>
                    <p>Ngày Đã Giao Hàng: <strong><?php
                    if($order['shippedDate'] != null){
                        $date = DateTime::createFromFormat('Y-m-d', $order['shippedDate']);
                        echo $date->format('d/m/Y'); 
                    }else{
                        echo "Chưa giao hàng";
                    }
                    ?></strong> </p>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-between align-items-center" style="gap: 25px;">
                <?php if($order['status'] === "Đã Xử Lý"):  ?>
                    <span class="badge bg-danger"><?php echo $order['status']; ?></span>
                <?php else: ?>
                    <span class="badge bg-primary"><?php echo $order['status']; ?></span>
                <?php endif; ?>
                <a class="text-decoration-none" href="/e-commerce-site/pages/orderDetail_manage.php?id=<?php echo $order['id']?>"><span class="text-muted fw-bold me-3">Xem Chi Tiết</span></a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p>Không tìm thấy đơn hàng nào.</p>
    <?php endif; ?>
</div>
</body>
</html>