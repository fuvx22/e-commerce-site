<?php 
    require_once "../model/orderModel.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['userId']) && isset($data['cart']) && isset($data['address']) && isset($data['phone'])){
            $cart = $data['cart'];
            $userId = $data['userId'];
            $address = $data['address'];
            $phoneNumber = $data['phone'];
            $status = "Chờ Xử Lý";
            $description = $data['note'];
            $result = orderModel::addOrder($userId, $status, $description, $address, $phoneNumber);
            $orderId = $result;
            if($orderId){
                foreach($cart as $item){
                    $productId = $item['id'];
                    $quantity = $item['quantity'];
                    $result = orderModel::addOrderDetail( $productId , $orderId, $quantity);
                    if(!$result){
                        echo json_encode(array("error" => "Có lỗi xảy ra khi thêm chi tiết đơn hàng"));
                        exit();
                    }
                    else{
                        echo json_encode(array("success" => "Đặt hàng thành công"));
                    }
                }
            } else {
                echo json_encode(array("error" => "Có lỗi xảy ra khi thêm đơn hàng"));
            }
        }
        
    }
?>