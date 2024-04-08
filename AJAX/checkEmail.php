<?php 
   require_once "../db_connect.php";
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $db = new Database();
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $db->query($sql);
        if($result->num_rows > 0){
            echo "exists";
        }
        else{
            echo "";
        }
        }
    
?>