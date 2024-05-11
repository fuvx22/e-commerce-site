<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/components/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
    if(isset($_POST['key'])){
        $key = $_POST['key'];
    }else{
        $key='';
    }
    $database = new Database();
    $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 8;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1; 
    $offset = ($current_page - 1) * $item_per_page;
    // Số sản phẩm hiển thị trong 1 trang bị giới hạn bởi 8
    $products = $database->query("SELECT * FROM product WHERE name LIKE '%".$key."%' LIMIT ".$item_per_page." OFFSET ".$offset);
    // Lấy tất cả số sản phẩm ứng với điều kiện
    $totalRecords = $database->query("SELECT * FROM product WHERE name LIKE '%".$key."%'");
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
?>

<div class="container mt-custom">
    <div class="row">
        <!-- Phần aside -->
        <div class="col-md-3 aside">
            <h5 class="text-uppercase">Bộ lọc tìm kiếm</h5>
            <p>Theo thể loại</p>
            <form action="assets/PHP/index.php" id="searchForm" class="row">
                <select id="category" name="category" class="col-6 mb-4 border">
                    <?php 
                        $result = $database->query("SELECT * FROM subcategory");
                        echo '<option value="0">Thể loại</option>';
                        while($row =mysqli_fetch_array($result)){
                            $name = $row['name'];
                            $id = $row['id'];
                            echo "<option value=\"$id\">$name</option>";
                        }
                    ?>
                </select>
                <p>Theo khoảng giá</p>
                <div class="row mb-4 justify-content-between mx-0 p-0">
                    <input class="border" type="number" id="minPrice" name="minPrice" placeholder="Giá từ">
                    -
                    <input class="border" type="number" id="maxPrice" name="maxPrice" placeholder="Giá đến">
                </div>
                <input class="col-12 h-100 mb-4" type="submit" value="Áp dụng"></input>
            </form>
        </div>
        
        <!-- Phần content -->
        <div class="col-md-9 row justify-content-start" id="search">
            <h3 class="text-center">Tìm kiếm</h3>
            <?php 
            if(mysqli_num_rows($products) == 0){
                echo "<p>Không tìm thấy sản phẩm <strong class='text-uppercase'>" .$key."</strong></p>";
            }
            ?>
            <?php while ($row = mysqli_fetch_array($products)){?>
                <a href="../pages/product_details.php?id=<?=$row['id']?>" class="col-md-4 m-4 text-dark" style="width: 12rem; text-decoration: none;">   
                    <img class="card-img-top" src="<?=$row['image']?>" alt="">
                    <div class="card-body">
                        <h3 card-title class="text-center"><?=$row['name']?></h3>
                        <p class="card-text text-center"><?=number_format($row['price'],0,",",".") ?> đ</p>
                    </div>
                </a>
            <?php }?>
            <!-- Phân trang -->
            <div class="text-center mb-5" id="pagenavi">
                <?php
                if($current_page > 3){
                    $first_page = 1;
                    echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$first_page.'">First</a>' . "\n";  
                }
                if ($current_page > 2){
                    $prev_page = $current_page - 1;
                    echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$prev_page.'">Prev</a>' . "\n";
                }
                ?>
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <?php if($i != $current_page){?>
                        <?php if($i > $current_page - 3 && $i < $current_page + 3){ ?>
                            <a class="text-muted mx-2 text-decoration-none" href="?per_page=<?=$item_per_page?>&page=<?=$i?>"><?=$i?></a>
                        <?php } ?>    
                    <?php } else {?>
                        <strong class="mx-2"><?=$i?></strong>
                    <?php }?>
                <?php } ?>
                <?php
                if ($current_page < $totalPages - 1){
                    $next_page = $current_page + 1;
                    echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$next_page.'">Next</a>' . "\n";
                }
                if($current_page < $totalPages - 2){
                    $end_page = $totalPages;
                    echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='. $item_per_page .'&page='. $end_page.'">Last</a>';
                }
            $database->close();
            ?>
            </div>
        </div>
        <div id="searchResults" class="col-md-9 row justify-content-start">

        </div>
    </div>
</div>
<div class="footer">
    <div class="footerleft">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/components/footer.php');?>
    </div>
</div>
</body>
</html>

<!-- Ajax -->
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        searchProducts(formData);
        var divSP = document.getElementById('search');
        var pageNavi = document.getElementById('pagenavi');
        divSP.style.display = 'none'; 
        pageNavi.style.display = 'none'; 
    });

    function searchProducts(formData) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_advanced.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                document.getElementById('searchResults').innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData);
    }
</script>
<script src="../javascripts/example.js"></script>
<script src="../javascripts/cart.js"></script>