<?php 
    require_once "../db_connect.php";
    class orderModel{
        public static function addOrder($userId, $status, $description, $address, $phoneNumber){
            $db = new Database();
            $sql = "INSERT INTO `order` (userId,  status, description, address, phoneNumber) VALUES ($userId,  '$status', '$description', '$address', '$phoneNumber')";
            $result = $db->insert($sql);
           return $result;
        }
        public static function addOrderDetail( $productId, $orderId, $quantity){
            $db = new Database();
            $sql = "INSERT INTO orderline ( productId, orderId, quantity) VALUES ( $productId,$orderId, $quantity)";
            $result = $db->insert($sql);
            return $result;
        }
    }
?>