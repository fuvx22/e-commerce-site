<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/load/load_category.php');
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
        <a href="/e-commerce-site" class="text-decoration-none text-primary">DP2NT</a>
    </span>
    <span class="topmenuright">
    <div class="search">
    <form action="/e-commerce-site/search_product/search.php" method="POST">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" placeholder="Tìm Kiếm" name="key">
    </form>  
      
    </div>
      <i class="fa-solid fa-circle-user" ></i>
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
    <?php
      load_categories();
    ?>
          <!-- <li class="danhmuc" onmouseenter="thaydoi1(1) " onmouseleave="thaydoi2(1)" ><a >ÁO KHOÁC<i class="fa-solid fa-chevron-down" id="thaydoiicon1"></i></a>
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
          </li> -->
        </ul>
  </div>
  </div>

  </body>
</html>


