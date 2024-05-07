<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Thêm font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Thêm font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Liên kết tới CSS tùy chỉnh của bạn -->
    
</head>
<body>
<?php require('../components/header.php'); ?>
<div class="container mt-4" style="padding-top: 110px;">
    <h3 class="text-center fw-normal mb-4">CHI TIẾT ĐƠN HÀNG</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <strong>Thông Tin Đơn Hàng</strong>
                </div>
                <div class="card-body">
                    <p>Mã đơn hàng: <strong><?php echo $order['id']?></strong> </p>
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
                    <p>Trạng thái: <strong><?php echo $order['status'] ?></strong> </p>
                    <p>Địa chỉ: <strong><?php echo $order['address'] ?></strong> </p>
                    <p>Số điện thoại: <strong><?php echo $order['phoneNumber'] ?></strong> </p>
                    <p>Ghi chú: <strong><?php echo $order['description'] ?></strong> </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Danh sách sản phẩm</strong>
                </div>
                <div class="card-body">
                    <div class="list-group ">
                    <?php if(is_array($products)):  $total = 0; ?>
                        <?php foreach($products as $product): ?>
                            <?php $total += $product['price'] * $product['quantity'];?>
                            <div class=" mb-3 border  rounded list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                <img src="<?php echo $product['image']?>" class="img-thumbnail me-3 product-image" style="width: 60px; height: 60px;">
                                    <div>
                                        <p>Tên sản phẩm: <a class="text-decoration-none text-black" href="/e-commerce-site/pages/product_details.php?id=<?php echo $product['id']?>"><strong><?php echo $product['name']?></strong></a> </p>
                                        <p>Số lượng: <strong><?php echo $product['quantity']?></strong></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                <span >Giá: <strong class="product-price"><?php echo number_format((float)$product['price'], 0, '.', ',')?></strong> VNĐ</span>                               
                             </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không tìm thấy đơn hàng nào.</p>
                        <?php endif; ?>
                    </div>
                  
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <span class="total-amount"><strong><?php echo number_format((float)$total, 0, '.', ',')?></strong> VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="../javascripts/example.js"></script>
<script src="../javascripts/cart.js"></script>

</html>