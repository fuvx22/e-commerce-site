<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isUpdate = $userAuth->checkUpdatePermission("2");

if (!$isUpdate) {
  header("Location: ../pages/product.php");
  exit();
}

$id = $_GET["id"];
$sql = "SELECT * FROM product WHERE id = '$id' LIMIT 1";
$res = $conn->query($sql);
$row = mysqli_fetch_assoc($res);

$roleId = $conn->query("SELECT * FROM role");

if (isset($_POST["submit"])) {

  $name = $_POST["product_name"];
  $price = $_POST["product_price"];
  $description = $_POST["product_description"];
  $categoryId = $_POST["product_category"];

  if ($_FILES["product_image"]["name"] != "") {
    $targetDirectory = "../uploads/";
    $image = $targetDirectory . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $image);
  } else {
    $image = $row['image'];
  }
  echo $image;

  $sql = "UPDATE `product` SET 
          `name`='$name',`image`='$image',`description`='$description', 
          `subcategoryId`='$categoryId',`price`='$price' WHERE id=$id";

  $result = $conn->query($sql);
  echo $sql;

  if ($result) {
    session_start();
    $_SESSION["product_msg"] = "Cập nhật sản phẩm thành công";
    header("Location: ../pages/product.php");
  }

  $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
  <div class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5374;">
    Header PHP
  </div>
  <div class="container">
    <div class="text-center">
      <h3>Cập nhật sản phẩm</h3>
    </div>



    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px;" enctype="multipart/form-data">
        <div class="mb-2">
          <label class="form-label">Tên sản phẩm:</label>
          <input type="text" class="form-control" required name="product_name" value="<?php echo $row['name'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Hình ảnh sản phẩm:</label>
          <input type="file" class="custom-file-input" name="product_image" style="opacity: 1;" accept="image/png, image/gif, image/jpeg">
          <p>Hình ảnh sản phẩm hiện tại: <?php echo $row['image'] ?></p>
        </div>
        <div class="mb-2">
          <label class="form-label">Mô tả sản phẩm:</label>
          <input type="text" class="form-control" required name="product_description" value="<?php echo $row['description'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Giá sản phẩm:</label>
          <input type="number" class="form-control" required name="product_price" value="<?php echo $row['price'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Thể loại:</label>
          <select class="custom-select" id="categorySelect" required name="product_category" required valueToSelect="<?php echo $row['subcategoryId'] ?>">
            <?php
            if ($categorys->num_rows > 0) {
              while ($row = $categorys->fetch_assoc()) {
                echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
              }
            }
            ?>
          </select>
        </div>

        <div class="mb-2 text-right">
          <button type="submit" class="btn btn-success" name="submit">Lưu</button>
          <a href="../pages/product.php" class="btn btn-danger">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</body>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var mySelect = document.getElementById("categorySelect");
    var valueToSelect = mySelect.getAttribute('valueToSelect');

    for (var i = 0; i < mySelect.options.length; i++) {
      if (mySelect.options[i].value === valueToSelect) {
        mySelect.selectedIndex = i;
        break;
      }
    }
  });
</script>

</html>