<?php 
    session_start();
    require_once "../model/orderModel.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["startDate"]) && isset($_POST["endDate"])){
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];
            $orders = orderModel::getOrderByDate($startDate, $endDate);
            $_SESSION['filtered_orders'] = $orders;
            $_SESSION['startDate'] = $startDate;
            $_SESSION['endDate'] = $endDate;
            header('Location: ../pages/order_manage.php');
        }
        else{
            echo "Khong tim thấy";
        }
    }
?>