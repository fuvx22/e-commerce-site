<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop bán hàng</title>
  <link rel="stylesheet" href="./css/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="./assets/fontawesome/css/all.min.css">
</head>

<body>
<?php
  require "./components/header.php";  
?>
  
  <div class="showimg">
    <div class="topmenu">
      <?php
      require "./components/topmenu.php";
      ?>
    </div>
  </div>
  <div class="content">

    <?php
    require "./components/content.php";
    ?>

  </div>
  <div class="footer">
    <div class="footerleft">
      <?php require "./components/footer.php";
      ?>
    </div>
</body>
<script src="./javascripts/example.js">
</script>
<script src="./javascripts/cart.js"></script>

</html>