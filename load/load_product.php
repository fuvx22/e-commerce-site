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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
    
    function load_products_8($subcategory){
        $database = new Database();
        $products = $database->query("SELECT * FROM product WHERE subcategoryId = " . $subcategory . " LIMIT 8");
        while($row = $products->fetch_assoc()){
            $image = $row['image'];
            $new_image = str_replace('../uploads/', './uploads/', $image);
            ?>
            <a href="./pages/product_details.php?id=<?=$row['id']?>" style="text-decoration: none;">
                <img src="<?=$new_image?>" alt="" class="img-fluid">
                <p class="text-center text-dark fs-5 mb-0"><?=$row['name']?></p>
                <p class="text-center text-dark fs-6 fw-bold "><?=number_format($row['price'],0,",",",")?>₫</p>
            </a>
        <?php }
        $database->close();
    }

    function load_products_16($subcategory) {
        $database = new Database();
        $subcategoryId = isset($_GET['subcategoryId']) ? $_GET['subcategoryId'] : 1;
        $subcategoryName = isset($_GET['subcategoryName']) ? $_GET['subcategoryName'] : ' ';
        $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 16;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $item_per_page;
        $products = $database->query("SELECT * FROM product WHERE subcategoryId = " . $subcategory . " LIMIT ".$item_per_page." OFFSET ".$offset);
        $totalRecords = $database->query("SELECT * FROM product WHERE subcategoryId = " . $subcategory);
        $totalRecords = $totalRecords->num_rows;
        $totalPages = ceil($totalRecords / $item_per_page);
        while($row = $products->fetch_assoc()){?>
            <a href="./product_details.php?id=<?=$row['id']?>" style="text-decoration: none;">
                <img src="<?=$row['image']?>" alt="" class="img-fluid">
                <p class="text-center text-dark fs-5 mb-0"><?=$row['name']?></p>
                <p class="text-center text-dark fs-6 fw-bold "><?=number_format($row['price'],0,",",",")?>₫</p>
            </a>
        <?php }?>
        <!-- Phân trang -->
        <div class="text-center mb-5" id="pagenavi" style="grid-column: span 4; grid-row: 5 / span 2;">
            <?php
            if($current_page > 3){
                $first_page = 1;
                echo '<a class="text-muted mx-2 text-decoration-none" href="?subcategoryId='.$subcategoryId.'&subcategoryName='.$subcategoryName.'&per_page='.$item_per_page.'&page='.$first_page.'">First</a>' . "\n";  
            }
            if ($current_page > 2){
                $prev_page = $current_page - 1;
                echo '<a class="text-muted mx-2 text-decoration-none" href="?subcategoryId='.$subcategoryId.'&subcategoryName='.$subcategoryName.'&per_page='.$item_per_page.'&page='.$prev_page.'">Prev</a>' . "\n";
            }
            ?>
            <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                <?php if($i != $current_page){?>
                    <?php if($i > $current_page - 3 && $i < $current_page + 3){ ?>
                        <a class="text-muted mx-2 text-decoration-none" href="?subcategoryId=<?=$subcategoryId?>&subcategoryName=<?=$subcategoryName?>&per_page=<?=$item_per_page?>&page=<?=$i?>"><?=$i?></a>
                    <?php } ?>    
                <?php } else {?>
                    <strong class="mx-2"><?=$i?></strong>
                <?php }?>
            <?php } ?>
            <?php
            if ($current_page < $totalPages - 1){
                $next_page = $current_page + 1;
                echo '<a class="text-muted mx-2 text-decoration-none" href="?subcategoryId='.$subcategoryId.'&subcategoryName='.$subcategoryName.'&per_page='.$item_per_page.'&page='.$next_page.'">Next</a>' . "\n";
            }
            if($current_page < $totalPages - 2){
                $end_page = $totalPages;
                echo '<a class="text-muted mx-2 text-decoration-none" href="?subcategoryId='.$subcategoryId.'&subcategoryName='.$subcategoryName.'&per_page='. $item_per_page .'&page='. $end_page.'">Last</a>';
            }
            ?>
        </div>
        <?php 
        $database->close();
    }
?>
</body>
</html>