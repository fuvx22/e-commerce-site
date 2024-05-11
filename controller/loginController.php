<?php 
    require_once "../model/userModel.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userData = userModel::CheckLogin($email, $password);
            if($userData){
                session_start();
                $_SESSION['userData'] = $userData; 
                header("Location:../index.php");
                
            } else {
                session_start();
                $_SESSION['error'] = "Tài khoản hoặc mật khẩu không đúng!";
                header("Location:../pages/login.php");
                exit(); // Đảm bảo không có mã nào được thực thi sau khi chuyển hướng
            }
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        header("Location:../pages/login.php");
        exit();
    }
?>
