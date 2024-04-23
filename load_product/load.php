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
    
</body>
</html>

<?php
    require_once("./db_connect.php");
    
    function load_products($subcategory){
        $database = new Database();
        $products = $database->query("SELECT * FROM product WHERE subcategoryId = " . $subcategory . " LIMIT 8");
        while($row = $products->fetch_assoc()){
            $image = $row['image'];
            $new_image = str_replace('../uploads/', './uploads/', $image);
            ?>
            <a href="./pages/product_details.php?id=<?=$row['id']?>" style="text-decoration: none;">
                <img src="<?=$new_image?>" alt="" >
                <p class="text-center text-dark fs-5 mb-0"><?=$row['name']?></p>
                <p class="text-center text-dark fs-6 fw-bold "><?=number_format($row['price'],0,",",",")?>₫</p>
            </a>
        <?php }
    }
?>