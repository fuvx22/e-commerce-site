<header>
  <div class="header-logo">
    <img src="./assets/nike-luka-1.webp" alt="logo">
    <h2>Shop15</h2>
  </div>
  <div class="category-container">
    <button class="category-btn">
      <i class="fa-solid fa-bars"></i>
      Danh mục
      <ul class="category-menu">
        <li class="category-item">Điện thoại, tablet</li>
        <li class="category-item">Laptop</li>
        <li class="category-item">Âm thanh</li>
        <li class="category-item">Đồng hồ</li>
        <li class="category-item">Camera</li>
        <li class="category-item">Gia dụng, smart house </li>
        <li class="category-item">Phụ kiện</li>
        <li class="category-item">Tivi</li>
        <li class="category-item">Linh kiện PC, màn hình</li>
        <li class="category-item">Điện thoại, tablet</li>
        <li class="category-item">Laptop</li>
        <li class="category-item">Âm thanh</li>
        <li class="category-item">Đồng hồ</li>
        <li class="category-item">Camera</li>
        <li class="category-item">Gia dụng, smart house </li>
        <li class="category-item">Phụ kiện</li>
        <li class="category-item">Tivi</li>
        <li class="category-item">Linh kiện PC, màn hình</li>
        <li class="category-item">Điện thoại, tablet</li>
        <li class="category-item">Laptop</li>
        <li class="category-item">Âm thanh</li>
        <li class="category-item">Đồng hồ</li>
        <li class="category-item">Camera</li>
        <li class="category-item">Gia dụng, smart house </li>
        <li class="category-item">Phụ kiện</li>
        <li class="category-item">Tivi</li>
        <li class="category-item">Linh kiện PC, màn hình</li>
        <li class="category-item">Điện thoại, tablet</li>
        <li class="category-item">Laptop</li>
        <li class="category-item">Âm thanh</li>
        <li class="category-item">Đồng hồ</li>
        <li class="category-item">Camera</li>
        <li class="category-item">Gia dụng, smart house </li>
        <li class="category-item">Phụ kiện</li>
        <li class="category-item">Tivi</li>
        <li class="category-item">Linh kiện PC, màn hình</li>
      </ul>
    </button>
  </div>
  <div class="header-gap"></div>
  <div class="search-container">
    <input class="search-input" type="text" placeholder="Tìm kiếm sản phẩm...">
    <button class="search-btn">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>  
  <div class="auth-section">
    <button class="login-btn"><a href="/e-commerce-site/pages/login.php">Đăng Nhập</a></button>
    <button class="register-btn">Đăng ký</button>
  </div>
</header>

<script>
  var categoryMenu = document.querySelector(".category-menu");

  var categoryBtn = document.querySelector(".category-btn")

  var icon = document.querySelector(".category-btn i");
  
  categoryBtn.addEventListener("click", function(event) {
    if (categoryMenu.style.display === "none") {
      categoryMenu.style.display = "grid";  
    }
    else {
      categoryMenu.style.display = "none";
    }

  });
  
  categoryMenu.addEventListener("click", function(event) { event.stopPropagation(); });

  window.addEventListener("click", function(event) {
    if (event.target != categoryMenu && event.target != categoryBtn && event.target != icon) {
      categoryMenu.style.display = "none";
    }
  })
  
</script>