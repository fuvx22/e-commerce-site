<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');

$database = new Database();

$category = $_POST['category'];
$minPrice = $_POST['minPrice'];
$maxPrice = $_POST['maxPrice'];
if (empty($minPrice) && empty($maxPrice)) {
    $minPrice = 0;
    $maxPrice = 1000000000;
}
if (empty($minPrice)) {
    $minPrice = 0;
}
if (empty($maxPrice)) {
    $maxPrice = 1000000000;
}

$item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 8;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $item_per_page;
// Biến $query là biến lấy giới hạn hiển thị (tìm thấy 10 nhưng chỉ lấy 8)
$query = "SELECT * FROM product WHERE subcategoryId = $category";
if (!empty($minPrice) || !empty($maxPrice)) {
    $query .= " AND price BETWEEN $minPrice AND $maxPrice LIMIT ".$item_per_page." OFFSET ".$offset;
}
$result = $database->query($query);
// Biến $queryAll là biến thấy tất cả dữ liệu ứng với điều kiện (tìm thấy 10 thì lấy 10)
$queryAll = "SELECT * FROM product WHERE subcategoryId = $category";
if (!empty($minPrice) || !empty($maxPrice)) {
    $queryAll .= " AND price BETWEEN $minPrice AND $maxPrice ";
}
$totalRecords = $database->query($queryAll);

$totalRecords = $totalRecords->num_rows;
$totalPages = ceil($totalRecords / $item_per_page);
echo '<h3 class="text-center">Tìm kiếm</h3>';
// Kiểm tra và hiển thị kết quả
if ($result->num_rows != 0) {
    while ($row = $result->fetch_assoc()) { ?>
        <a href="../pages/product_details.php?id=<?=$row['id']?>" class="col-md-4 m-4 text-dark" style="width: 12rem; text-decoration: none;">   
            <img class="card-img-top" src="<?=$row['image']?>" alt="">
            <div class="card-body">
                <h3 card-title class="text-center"><?=$row['name']?></h3>
                <p class="card-text text-center"><?=number_format($row['price'],0,",",".") ?> đ</p>
            </div>
        </a>
    <?php }
    ?>
    <!-- Phân trang -->
    <div class="text-center mb-5" id="pagenavi">
        <?php
        if ($current_page > 3) {
            $first_page = 1;
            echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$first_page.'">First</a>'."\n";
        }
        if ($current_page > 2) {
            $prev_page = $current_page - 1;
            echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$prev_page.'">Prev</a>'."\n";
        }
        ?>
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <?php if ($i != $current_page) { ?>
                <?php if ($i > $current_page - 3 && $i < $current_page + 3) { ?>
                    <a class="text-muted mx-2 text-decoration-none" href="?per_page=<?= $item_per_page ?>&page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
            <?php } else { ?>
                <strong class="mx-2"><?= $i ?></strong>
            <?php } ?>
        <?php } ?>
        <?php
        if ($current_page < $totalPages - 1) {
            $next_page = $current_page + 1;
            echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$next_page.'">Next</a>'."\n";
        }
        if ($current_page < $totalPages - 2) {
            $end_page = $totalPages;
            echo '<a class="text-muted mx-2 text-decoration-none" href="?per_page='.$item_per_page.'&page='.$end_page.'">Last</a>';
        }
        ?>
    <?php
} else {
    echo '<h3 class="text-center">Không sản phẩm nào được tìm thấy</h3>';
}
// Đóng kết nối
$database->close();
?>
