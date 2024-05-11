<?php 
require_once "../model/orderModel.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $orderId = $_POST["orderId"];
        $status = $_POST["statusSelected"];
        if($status === "Đã Xử Lý"){
            $orderProducts = orderModel::getProductByOrderId($orderId);
            foreach ($orderProducts as $orderProduct) {
                // Lấy thông tin về sản phẩm
                $product = orderModel::getProductById($orderProduct['id']);
                // Kiểm tra số lượng sản phẩm
                if ($product['quantity'] < $orderProduct['quantity']) {
                    session_start();
                    $_SESSION["orderUpdateStatus_msg"] = "Sản phẩm {$product['name']} không đủ số lượng để đáp ứng đơn hàng.";
                    header("Location: ../pages/orderDetail_manage.php?id=$orderId");
                    return;
                }
            }
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