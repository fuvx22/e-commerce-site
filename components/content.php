<?php
  require("./load_product/load.php");
?>
<div class="aopolo">
    <h3>ÁO POLO</h3>
    <img src="./img/aopolobig.jpg"  width="100%">
    <div class="itemaopolo">
      <?php 
        load_products(1); // Hàm trong file load.php
      ?>
    <!-- <img src="./img/aopolo1.jpg" height="300px" width="20%">
    <img src="./img/aopolo1.jpg" height="300px" width="20%">
    <img src="./img/aopolo1.jpg"  height="300px" width="20%">
    <img src="./img/aopolo1.jpg"  height="300px" width="20%">
    <img src="./img/aopolo2.jpg"  height="300px" width="20%">
    <img src="./img/aopolo2.jpg"  height="300px" width="20%">
    <img src="./img/aopolo2.jpg"  height="300px" width="20%">
    <img src="./img/aopolo2.jpg"  height="300px" width="20%"> -->
    </div>
    <div class="aophong">
      <h3>ÁO PHÔNG</h3>
      <img src="./img/aophongbig.jpg"  width="100%">
      <div class="itemaophong">
        <?php 
          load_products(2); // Hàm trong file load.php
        ?>
        <!-- <img src="./img/aophong1.jpg" height="300px" width="20%">
        <img src="./img/aophong2.jpg" height="300px" width="20%">
        <img src="./img/aophong1.jpg" height="300px" width="20%">
        <img src="./img/aophong2.jpg" height="300px" width="20%">
        <img src="./img/aophong3.jpg" height="300px" width="20%">
        <img src="./img/aophong3.jpg" height="300px" width="20%">
        <img src="./img/aophong3.jpg" height="300px" width="20%">
        <img src="./img/aophong3.jpg" height="300px" width="20%"> -->
      </div>
      <div>

      </div>
    </div>
    </div>