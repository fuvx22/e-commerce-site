<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <style>
        .chart {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            margin: 20px auto;
            padding: 20px;
        }
        .bar {
            display: inline-block;
            width: 20px;
            background-color: black;
            margin-right: 10px;
            transition: height 0.5s;
        }
        .row {
            display: flex;
            flex-direction: row;
        }
        .col-md-4 {
            flex: 1;
        }
    </style>
</head>
<body>
    <?php
        require('../components/header.php');
    ?>
    <div class="container" style="margin-top: 150px;">
    <h1 class="fs-1 text-center">THỐNG KÊ</h1>
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-sm">Doanh thu</button>
            <button type="button" class="btn btn-primary btn-sm">Sản phẩm</button>
        </div>  
    </div>
</body>
</html>