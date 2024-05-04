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
</head>
<body>
   <?php 
    require('../components/header.php');
   ?>
    <div class="container mt-4" style="padding-top: 140px;">
        <h2 class="text-center fw-normal">GIỎ HÀNG CỦA BẠN</h2>
        <!-- Danh sách sản phẩm -->
        <div class="row">
        <!-- Cột trái: danh sách sản phẩm -->
        <div class="col-md-8">
            <!-- Tạo card cho danh sách sản phẩm -->
            <div class="card">
                <div class="card-header">
                    <strong>Danh sách sản phẩm</strong>
                </div>
                <div class="card-body">
                    <!-- List group cho danh sách sản phẩm -->
                    <div class=" d-flex flex-column justify-content-center align-items-center">
                        <p class="cart-hide-p"></p>
                        <a href="/e-commerce-site/index.php" class=" cart-hide-a btn btn-outline-dark text-align-center"></a>
                    </div>
                    
                    <div class="list-group">
                       
                        <!-- Một mục danh sách sản phẩm -->
                        <div class="list-group-item d-flex justify-content-between align-items-center product-item">
                            <!-- Thông tin sản phẩm -->
                            <div class="d-flex align-items-center">
                                <img src="" class="img-thumbnail me-3 product-image" style="width: 60px; height: 60px;">
                                <div>
                                    <h5 class="mb-1 product-name"></h5>
                                    <p class="mb-1 ">Số lượng: 
                                        <button class="btn btn-sm btn-outline-secondary decrease-quantity">-</button>
                                        <span class="product-quantity"></span>
                                        <button class="btn btn-sm btn-outline-secondary increase-quantity">+</button>
                                    </p>
                                </div>
                            </div>
                            <!-- Giá sản phẩm và nút xóa -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-bolder product-price" style="margin-right: 10px;"></span>
                                <button class="btn btn-sm btn-outline-dark remove-item" data-index="">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải: tổng giá và nút thanh toán -->
        <div class="col-md-4">
            <!-- Tạo card cho tổng giá và nút thanh toán -->
            <div class="card">
                <div class="card-header">
                    <strong>Thông tin đơn hàng</strong>
                </div>
                <div class="card-body">
                    <!-- Tổng giá -->
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <span class="total-amount"></span>
                    </div>
                    <!-- Nút thanh toán -->
                    <div class="mt-4 d-flex justify-content-center">
                        <a href="/e-commerce-site/pages/order.php" class="order-btn btn btn-dark w-100 ">Đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>  
</body>
<script src="../javascripts/example.js"></script>
<script src="../javascripts/cart.js"></script>
<script src="../javascripts/cartDetails.js"></script>
</html>