<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['userData'])) {
        // Nếu chưa đăng nhập, điều hướng đến trang đăng nhập
        header("Location: /e-commerce-site/index.php");
        exit();
    }
    ?>
    <?php
    require("../components/header.php")
    ?>
    <div class="login-container">
        <div class="login">
            <div class="login-left">
                <h1>Đăng Nhập</h1>
                <hr class="hr" width="10%" align="center" />
            </div>
            <div class="login-right">
                <?php
                if (isset($_SESSION["error"])) {
                    $msg = $_SESSION["error"];
                    echo '
                    <div id="myAlert" class="alert alert-danger alert-dismissible fade show" role="alert">'
                    . $msg .
                    '
                    </div>';
                    unset($_SESSION["error"]);
                }
                if (isset($_SESSION["success"])) {
                    $msg = $_SESSION["success"];
                    echo '
                    <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
                    . $msg .
                    '
                    </div>';
                    unset($_SESSION["success"]);
                }
                ?>
                <form action="../controller/loginController.php" method="post">
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="password" name="password" placeholder="Your Password" required>
                    <div class="btn">
                        <button class="btn-login">Đăng Nhập</button>
                    </div>
                    <div class="forgot-register">
                        <a href="#">Quên Mật Khẩu</a>
                        <p>Hoặc</p> <a href="../pages/register.php">Đăng Kí</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
<script src="../javascripts/example.js"></script>
<script src="../javascripts/cart.js"></script>

</html>