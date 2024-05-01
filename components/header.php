<?php 
session_start();
?>
<div class="header">
<div class="head-text">
  <div class="text">
  <p id ="ftext">ĐĂNG KÝ TÀI KHOẢN ĐỂ MUA SẮM</p>
   <p id="ftext">ĐỔI TRẢ HÀNG MIỄN PHÍ</p>
  </div>
</div>
<div class="wrapper">
    <span class="topmenuleft">
      DP2NT
  </span>
   <span class="topmenuright">
   <div class="search">
   <form action="/e-commerce-site/search_product/search.php" method="POST">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" placeholder="Tìm Kiếm" name="key">
   </form>  
    
   </div>
   <?php if (isset($_SESSION['userData'])): ?>
    <?php 
    // Người dùng đã đăng nhập
    $userData = $_SESSION['userData'];
    // Xuất thông tin người dùng trong một thẻ HTML
    ?>
    <a href="#">Welcome, <?= htmlspecialchars($userData['name'], ENT_QUOTES, 'UTF-8') ?></a>
    <div class="dropdown-menu">
            <a href="/path/to/change-info.php">Thay đổi thông tin</a>
            <a href="/path/to/logout.php">Đăng xuất</a>
        </div>
<?php else: ?>
    <?php 
    // Người dùng chưa đăng nhập
    ?>
    <a href="/e-commerce-site/controller/loginController.php"><i class="fa-solid fa-circle-user"></i></a>
<?php endif; ?>


    
    <i class="fa-regular fa-heart"></i>
    <a><i class="fa-solid fa-cart-shopping" id="cart"></i>
   </a>
  </span>
  <div class="product">
  <div class="cart" id="giohang">
    <div class="cart_header">
    <h3>Giỏ hàng</h3>
    <i class="fa-solid fa-arrow-right" id="icon_arrow"></i>
    </div>
    <ul>
      <li><img src="./img/aopolo1.jpg" height="80px" width="15%"></li>
      <li><img src="./img/aopolo1.jpg" height="80px" width="15%"></li>
      <li><img src="./img/aopolo1.jpg" height="80px" width="15%"></li>
      <li><img src="./img/aopolo1.jpg" height="80px" width="15%"></li>
    </ul>
    <div class="cart_footer">
      <div>
      <p>Tổng tiền</p>
      </div>
      <span></span>
      
      <a>Xem giỏ hàng</a>
      <a>Thanh toán</a>
    </div>
  </div>
  </div>
</div>
<div class="head-bottom">
<ul class="lietke">
        <li class="danhmuc" onmouseenter="thaydoi1(1) " onmouseleave="thaydoi2(1)" ><a >ÁO KHOÁC
        <i class="fa-solid fa-chevron-down" id="thaydoiicon1"></i>
        </a>
          <ul class="item">
          <li class="item1">Áo Khoác Nỉ</li>
          <li class="item22">Áo Khoác Dù</li>
          <li>Áo Khoác Jean</li>
          <li>Áo Khoác Kaki</li>
          </ul>
        </li>
        <li class="danhmuc" onmouseenter="thaydoi1(2) " onmouseleave="thaydoi2(2)"><a >ÁO THUN
        <i class="fa-solid fa-chevron-down" id="thaydoiicon2"></i>
        </a>
          <ul class="item">
            <li>Áo Thun Tay Dài</li>
            <li>Áo Thun Tay Ngắn </li>
            <li>Áo Thun Polo</li>
          </ul>
        </li>
        <li class="danhmuc" onmouseenter="thaydoi1(3) " onmouseleave="thaydoi2(3)"><a >ÁO SƠ MI
        <i class="fa-solid fa-chevron-down" id="thaydoiicon3"></i>
        </a>
          <ul class="item">
            <li>Áo Sơ Mi Tay Dài</li>
            <li>Áo Sơ Mi Tay Ngắn</li>
          </ul>
        </li>
        <li class="danhmuc" onmouseenter="thaydoi1(4) " onmouseleave="thaydoi2(4)"><a >QUẦN DÀI
        <i class="fa-solid fa-chevron-down" id="thaydoiicon4"></i>
        </a>
          <ul class="item">
            <li>Quần Tây</li>
            <li>Quần Kaki</li>
            <li>Quần Jean</li>
          </ul>
        </li>
        <li class="danhmuc" onmouseenter="thaydoi1(5) " onmouseleave="thaydoi2(5)"><a >PHỤ KIỆN
        <i class="fa-solid fa-chevron-down" id="thaydoiicon5"></i>
        </a>
          <ul class="item">
            <li>Dây Nịt</li>
            <li>Nón</li>
            <li>Vớ</li>
          </ul>
        </li>
      </ul>
</div>
</div>

