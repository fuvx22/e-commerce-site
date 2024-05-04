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
    session_start();
    if (!isset($_SESSION['userData'])) {
        // Nếu chưa đăng nhập, điều hướng đến trang đăng nhập
        header("Location: /e-commerce-site/pages/login.php");
        exit();
    }
    $userData = $_SESSION['userData'];
    require('../components/header.php')
    ?>
        
       <div class="container mt-4" style="padding-top: 120px;">
         <div class="row">
            <!-- Cột bên trái: Form lấy địa chỉ của khách hàng -->
            <div class="col-md-6">
        <p class="fw-bolder mb-3">THÔNG TIN GIAO HÀNG</p>
                <form id="shipping-form">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['userData']['name'] ?>" required readonly style="padding: 20px;">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['userData']['email'] ?>" required readonly style="padding: 20px;">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="address" name="address" required placeholder="Nhập địa chỉ giao hàng ( vui lòng nhập cả thành phố ) "  style="padding: 20px;">
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required style="padding: 20px;">
                    </div>
                    <p class="error-message text-danger"></p>
                    <div class="mb-3">
                        <select class="form-select form-control" id="payment-method" name="payment-method" required style="padding: 15px">
                            <option value="">Chọn phương thức thanh toán</option>
                            <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                        </select>
                    </div>
                    <p class="error-message-payment text-danger"></p>
                    <div class="mb-3">
                        <textarea class="form-control form-control-lg" id="note" name="note" rows="4" placeholder="Nhập ghi chú nếu có"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                    <a href="/e-commerce-site/pages/cart.php" class="text-dark text-decoration-none">Giỏ hàng</a>
                    <button type="submit" data-user-id="<?=$userData['id']?>" onClick="handleOrdering(event)"  class="btn btn-outline-dark text-end">Đặt hàng</button>               
                    </div>
                 </form>
            </div>
            
            <!-- Cột bên phải: Danh sách sản phẩm được đặt -->
            <div class="col-md-6">
                <p class="fw-bolder mb-3">ĐƠN HÀNG</p>
                <div id="product-list">
                    <!-- Ví dụ về thẻ card cho một sản phẩm -->
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <!-- Hình ảnh sản phẩm -->
                                <img src="" class="img-fluid rounded-start" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <p class="card-text quantity-order "></p>
                                    <p class="card-text product-price"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bạn cần tự cập nhật danh sách sản phẩm từ giỏ hàng của người dùng -->
                </div>
                <div class="d-flex justify-content-between">
                    <p class="fw-medium">Tổng Cộng:</p>
                    <h5 id="total"></h5>
                </div>
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Đặt hàng thành công</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Cảm ơn bạn đã đặt hàng! Chúng tôi sẽ xử lý đơn hàng sớm nhất có thể.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Đóng</button>
                        </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tổng cộng của đơn hàng, bạn cần tự cập nhật dựa trên giỏ hàng -->
            </div>
        </div>
    </div>
   
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../javascripts/example.js"></script>
<script src="../javascripts/cart.js"></script>
<script src="../javascripts/order.js"></script>
</html>