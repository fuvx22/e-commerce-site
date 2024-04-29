<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isCreate = $userAuth->checkCreatePermission("4");

if (!$isCreate) {
  header("Location: ../pages/category.php");
  exit();
}

$categorys = $conn->query("SELECT * FROM category");

if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $categoryId = $_POST["categoryId"];

  $sql = "INSERT INTO `subcategory`(`categoryId`, `name`) VALUES ('$categoryId','$name')";

  $result = $conn->query($sql);

  if ($result) {
    session_start();
    $_SESSION["subcategory_msg"] = "thêm mới thể loại thành công";
    header("Location: ../pages/category.php");
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
      <h3>Thêm mới thể loại sản phẩm</h3>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px;">
        <div class="mb-2">
          <label class="form-label">Nhập tên thể loại:</label>
          <input type="text" class="form-control" required name="name">
        </div>
        <div class=" mb-2">
          <label class="form-label">Chọn danh mục của thể loại:</label>
          <select class="custom-select" id="categorySelect" required name="categoryId" required">
            <?php
            if ($categorys->num_rows > 0) {
              while ($row = $categorys->fetch_assoc()) {
                echo '<option value=' . $row['id'] . '>' . $row['category_name'] . '</option>';
              }
            }
            ?>
          </select>
        </div>

        <div class="mb-2 text-right">
          <button type="submit" class="btn btn-success" name="submit">Lưu</button>
          <a href="../pages/category.php" class="btn btn-danger">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</body>


</html>