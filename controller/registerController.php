<?php 
    require_once "../model/userModel.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['date'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $date = $_POST['date'];
            $today = new DateTime(date("Y-m-d"));
            $birthday = new DateTime($date);
            $diff = $today->diff($birthday);
            $age = $diff->y;
            $role = 2;
            $enrollDate = date("Y-m-d");
            if(!preg_match('/^[a-zA-ZÀ-ỹ\s]+$/u', $name)){
                header("Location:../pages/register.php?error=failed");
                exit();
            }
            $userData = userModel::registerUser($name, $age, $email, $password, $role, $enrollDate );
            if($userData){
                session_start();
                $_SESSION['success'] = "Đăng Kí Tài Khoản Thành Công!";
                header("Location:../pages/login.php");
            } else {
                echo 'Đăng Kí Không Thành Công';
            }
        }
    }
?>