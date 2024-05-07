<?php 
    require_once('../model/orderModel.php');
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        session_start();
        if(isset ($_SESSION['userData'])){
            $userId = $_SESSION['userData']['id'];
            $orders = orderModel::getOrderById($userId);
            $count = orderModel::countUserOrdered($userId);
            $countPending = orderModel::countOrderPending($userId);
            require '../pages/user-ordered.php'; 
        }
    }
?>