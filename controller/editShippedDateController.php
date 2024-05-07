<?php 
    require_once "../model/orderModel.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $orderId = $_POST['orderId'];
        $shippedDate = $_POST['shippedDate'];
        $result = orderModel::updateShippedDate($orderId, $shippedDate);
        if($result){
            session_start();
            $_SESSION['orderUpdateShippedDate_msg'] = "Cập nhật ngày đã giao hàng thành công";
            header("Location: ../pages/orderDetail_manage.php?id=$orderId");
        }
    }
?>