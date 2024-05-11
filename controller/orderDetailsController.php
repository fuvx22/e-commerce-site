<?php
    require_once('../model/orderModel.php');
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $order = orderModel::getOrderByIdOrder($id);
            $orderPayment = orderModel::getOrderPayment($id);
            $products = orderModel::getProductByOrderId($id);
            require('../pages/user-orderedDetails.php');
        }
    }
?>