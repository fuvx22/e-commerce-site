<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <!-- Thêm CSS của Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Thêm font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Thêm font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Liên kết tới CSS tùy chỉnh của bạn -->
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <?php require('../components/header.php'); ?>

    <div class="container mt-4" style="padding-top: 80px;">
    <!-- Tạo một hàng (row) -->
    <h3 class="text-center fw-normal mb-4">DANH SÁCH ĐƠN HÀNG ĐÃ ĐẶT</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <strong>Thống Kê</strong>
                </div>
                <div class="card-body">
                    <!-- Hiển thị số lượng đơn hàng đã đặt -->
                    <p>Số đơn hàng đã đặt: <strong><?php echo $count ?></strong> </p>
                    <p>Đang Xử Lý: <strong><?php echo $countPending?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Danh sách đơn hàng đã đặt</strong>
                </div>
                <div class="card-body">
                    <!-- Sử dụng list-group để hiển thị danh sách sản phẩm -->
                    <div class="list-group ">
                        <!-- Mục sản phẩm -->
                        <?php if(is_array($orders)): ?>
                        <?php foreach($orders as $order): ?>
                            <div class=" mb-3 border  rounded list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p>Mã đơn hàng: <strong><?php echo $order['id']; ?></strong> </p>
                                        <p>Ngày đặt: <strong><?php 
                                        $date = DateTime::createFromFormat('Y-m-d', $order['enrollDate']);
                                        echo $date->format('d/m/Y'); 
                                        ?></strong> </p>
                                        <p>Ngày Đã Giao Hàng: <strong><?php
                                        if($order['shippedDate'] != null){
                                            $date = DateTime::createFromFormat('Y-m-d', $order['shippedDate']);
                                            echo $date->format('d/m/Y'); 
                                        }else{
                                            echo "Chưa giao hàng";
                                        }
                                        ?></strong> </p>
                                        <p>Trạng thái: <strong> <?php echo $order['status']; ?></strong></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-decoration-none" href="/e-commerce-site/controller/orderDetailsController.php?id=<?php echo $order['id']?>"><span class="text-muted fw-bold me-3">Xem Chi Tiết</span></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không tìm thấy đơn hàng nào.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Thêm script cho Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <!-- Thêm script của bạn -->
    <script src="../javascripts/example.js"></script>
    <script src="../javascripts/cart.js"></script>
</body>

</html>
