<?php 
    require_once "../db_connect.php";
    class userModel{
        public static function CheckLogin($email, $password){
            $db = new Database();
            $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
            $result = $db->query($sql);
            if($result->num_rows >0) {
                return $result->fetch_assoc();
            }
            else{
                return false;
            }
        }
        public static function registerUser($name, $age, $email, $password,$role, $enrollDate){
            $db = new Database();
            $sql = "INSERT INTO user (name, age, email, password, roleId, enrollDate) VALUES ('$name', '$age', '$email', '$password', '$role', '$enrollDate')";
            $result = $db->query($sql);
            if($result) {
                return true;
            }
            else{
                return false;
            }
        }
    }
   
?>