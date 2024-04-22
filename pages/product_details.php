<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
    <?php 
        require('../components/header.php');
        require_once("../db_connect.php");
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $database = new Database();
        $product = $database -> query('SELECT * FROM product WHERE id ='.$id);
        $row = $product->fetch_assoc();
    ?>
    <div class="container" style="margin-top: 140px">
        <div class="row" >
            <img src="<?=$row['image']?>" alt="" class="col-md-7 img-fluid">
            <div class="col-md-5">
                <h1 class="border-bottom border-success p-2 border-opacity-10">Tên sản phẩm: <?=$row['name']?></h1>
                <p class="border-bottom border-success p-2 border-opacity-10">Mã sản phẩm: <?=$row['id']?></p>
                <p class="border-bottom border-success p-2 border-opacity-10">Giá sản phẩm: <?=$row['price']?></p>
                <p style="text-decoration: underline; font-weight: bold;">Mô tả: </p>
                <p><?=$row['description']?></p>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary">Left</button>
                    <button type="button" class="btn btn-primary">Middle</button>
                    <button type="button" class="btn btn-primary">Right</button>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button">Thêm vào giỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

