<?php
  require("./load/load_product.php");
?>
<div class="aopolo">
    <h3>ÁO POLO</h3>
    <img src="./img/aopolobig.jpg" width="100%">
      <div class="landing-product-container mt-4">
        <?php 
          load_products_8(1); // Hàm trong file load.php
        ?>
      </div>
    <div class="aophong">
      <h3>ÁO PHÔNG</h3>
      <img src="./img/aophongbig.jpg"  width="100%">
      <div class="landing-product-container mt-4">
        <?php 
          load_products_8(2); // Hàm trong file load.php
        ?>
      </div>
      <div>

      </div>
    </div>
    </div>