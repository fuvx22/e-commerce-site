<?php 
    require_once "../db_connect.php";
    class orderModel{
        public static function getOrder(){
            $db = new Database();
            $sql = "SELECT * FROM `order`";
            $result = $db -> query($sql);
            if($result->num_rows > 0){
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            else{
                return false;
            }
        }
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
        public static function getOrderById($userId){
            $db = new Database();
            $sql = "SELECT * FROM `order` WHERE userId = '$userId'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            else{
                return false;
            }
        }
        public static function countUserOrdered($userId){
            $db = new Database();
            $sql = "SELECT COUNT(*) FROM `order` WHERE userId = '$userId'";
            $result = $db->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }
        public static function countOrderPending($userId){
            $db = new Database();
            $sql = "SELECT COUNT(*) FROM `order` WHERE userId = '$userId' AND status = 'Chờ Xử Lý'";
            $result = $db->query($sql);
            $row = $result->fetch_row();
            return $row[0];
        }
        public static function getOrderByIdOrder($orderId){
            $db = new Database();
            $sql = "SELECT * FROM `order` WHERE id = '$orderId'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                return $result->fetch_assoc();
            }
            else{
                return false;
            }
        }
        public static function getProductByOrderId($orderId){
            $db = new Database();
            $sql = "SELECT p.id, p.name, p.image, p.price, od.quantity FROM `orderline` od 
            INNER JOIN product p ON od.productId = p.id WHERE od.orderId = '$orderId'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            else{
                return false;
            }
        }
        public static function getProductById($productId){
            $db = new Database();
            $sql = "SELECT * FROM product WHERE id = '$productId'";
            $result = $db->query($sql);
            $product = $result->fetch_assoc();
            return $product;
        }
        public static function updateOrderStatus($orderId, $status){
            $db = new Database();
            $sql1 = "UPDATE `order` SET status = '$status' WHERE id = '$orderId'";
            $result1 = $db->query($sql1);
            $sql2 = "UPDATE `product` p INNER JOIN `orderline` od ON p.id = od.productId 
            SET p.quantity = p.quantity - od.quantity WHERE od.orderId = '$orderId'";
            $result2 = $db->query($sql2);
            return  $result1 && $result2;
        }
        public static function updateOrderStatusPending($orderId, $status){
            $db = new Database();
            $sql1 = "UPDATE `order` SET status = '$status' WHERE id = '$orderId'";
            $result1 = $db->query($sql1);
            $sql2 = "UPDATE `product` p INNER JOIN `orderline` od ON p.id = od.productId 
            SET p.quantity = p.quantity + od.quantity WHERE od.orderId = '$orderId'";
            $result2 = $db->query($sql2);
            return  $result1 && $result2;
        }
        public static function updateShippedDate($orderId, $shippedDate){
            $db = new Database();
            $sql = "UPDATE `order` SET shippedDate = '$shippedDate' WHERE id = '$orderId'";
            $result = $db->query($sql);
            return $result;
        }
    }
?>