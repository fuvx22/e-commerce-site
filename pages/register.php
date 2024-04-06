<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Tài Khoản</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>
<body>
    <?php
      require("../components/header.php")
    ?>
    <div class="register-container">
        <div class="register">
            <div class="register-left">
                <h1>Tạo Tài Khoản</h1>
                <hr class="hr"  width="10%" align="center" />
            </div>
            <div class="register-right">
            <?php
            if(isset($_GET['error']) && $_GET['error'] === 'failed') {
                echo '<p class="error-message" >Thông tin Đăng Kí không hợp lệ!</p>';
            }
            ?>
            <form action="../controller/registerController.php" method="post"> 
            <input class="input-register" type="text" name="name" placeholder="Your Full Name" required>
            <input class="input-register" type="number" name="age" placeholder="Your Age" required>
            <input class="input-register input-email" type="email"  name="email" placeholder="Your Email" required>
            <p class="error-email" style="display:none;"></p>
            <input class="input-register" type="password" name="password" placeholder="Your Password" required>
            <div class="btn">
                <button class="btn-register">Đăng Kí</button> 
            </div>
            <div class="forgot-register">
                <a href="../index.php" ><i class="fas fa-long-arrow-alt-left icon-arrow"></i>Quay Về Trang Chủ</a>
            </div>
        </form>
            </div>
        </div>
    </div>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="../javascripts/register.js"></script>
</body>

</html>