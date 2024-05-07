<?php 
require_once "../model/orderModel.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $orderId = $_POST["orderId"];
        $status = $_POST["statusSelected"];
        if($status === "Đã Xử Lý"){
            $orderStatusUpdate = orderModel::updateOrderStatus($orderId, $status);
            if($orderStatusUpdate){
                session_start();
                $_SESSION["orderUpdateStatus_msg"] = "Cập nhật đơn hàng thành công";
                header("Location: ../pages/orderDetail_manage.php?id=$orderId");
            }
            else{
                echo "Cap nhat don hang that bai";
            }
        }
        else{
            $orderStatusUpdate = orderModel::updateOrderStatusPending($orderId, $status);
            if($orderStatusUpdate){
                session_start();
                $_SESSION["orderUpdateStatus_msg"] = "Cập nhật đơn hàng thành công";
                header("Location: ../pages/orderDetail_manage.php?id=$orderId");
            }
            else{
                echo "Cap nhat don hang that bai";
            }
        }
        
        
    }
?>