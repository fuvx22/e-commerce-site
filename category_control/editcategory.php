<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isUpdate = $userAuth->checkUpdatePermission("4");

if (!$isUpdate) {
  header("Location: ../pages/category.php");
  exit();
}

$id = $_GET["id"];
$sql = "SELECT * FROM category WHERE id = '$id' LIMIT 1";
$res = $conn->query($sql);
$row = mysqli_fetch_assoc($res);

if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $description = $_POST["description"];

  $sql = "UPDATE `category` SET 
          `category_name`='$name',`description`='$description'
          WHERE id=$id";

  $result = $conn->query($sql);
  echo $sql;

  if ($result) {
    session_start();
    $_SESSION["subcategory_msg"] = "Cập nhật danh mục sản phẩm thành công";
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
      <h3>Cập nhật danh mục sản phẩm</h3>
    </div>



    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px;">
        <div class="mb-2">
          <label class="form-label">Tên danh mục sản phẩm:</label>
          <input type="text" class="form-control" required name="name" value="<?php echo $row['category_name'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Mô tả danh mục sản phẩm:</label>
          <input type="text" class="form-control" required name="description" value="<?php echo $row['description'] ?>">
        </div>
        <div class="mb-2 text-right">
          <button type="submit" class="btn btn-success" name="submit">Lưu</button>
          <a href="../pages/category.php" class="btn btn-danger">Hủy</a>
        </div>
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