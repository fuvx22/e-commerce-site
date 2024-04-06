<?php 
    require_once "../model/userModel.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['age'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $age = $_POST['age'];
            $role = 2;
            $enrollDate = date("Y-m-d");
            if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name) || $age >= 80 ){
                header("Location:../pages/register.php?error=failed");
                exit();
            }
            $userData = userModel::registerUser($name, $age, $email, $password, $role, $enrollDate );
            if($userData){
                header("Location:../pages/login.php?success=register-success");
            } else {
                echo 'Đăng Kí Không Thành Công';
            }
        }
    }
?>