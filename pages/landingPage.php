<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
</head>

<body>
    Đây là Trang Chủ
    <?php
    session_start();
    if (isset($_SESSION['userData'])) {
        echo "<pre>";
        print_r($_SESSION['userData']);
        echo "</pre>";
    } else {
        header("Location:login.php");
    }
    ?>
</body>

</html>