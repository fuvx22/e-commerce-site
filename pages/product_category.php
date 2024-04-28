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
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
    <?php
    require($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/components/header.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/load/load_product.php');
    $subcategoryId = isset($_GET['subcategoryId']) ? $_GET['subcategoryId']:1;
    $subcategoryName = isset($_GET['subcategoryName']) ? $_GET['subcategoryName']:' ';
    ?>
    <div class="container" style="margin-top: 200px">
        <p class="fs-2 fw-bold"><?=$subcategoryName?></p>
        <div class="landing-product-container">
            <?php load_products_16($subcategoryId);?>
        </div>
    </div>
    <div class="footer">
    <div class="footerleft">
      <?php require($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/components/footer.php');?>
    </div>
</body>
</html>