<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isUpdate = $userAuth->checkUpdatePermission("5");

if (!$isUpdate) {
  header("Location: ../pages/user.php");
  exit();
}
$id = $_GET["id"];
$sql = "SELECT * FROM user WHERE id = '$id' LIMIT 1";
$res = $conn->query($sql);
$row = mysqli_fetch_assoc($res);

$roleId = $conn->query("SELECT * FROM role");

if (isset($_POST["submit"])) {
  $name = $_POST["user_name"];
  $password = $_POST["user_password"];
  $age = $_POST["user_age"];
  $enrollDate = $_POST["user_enrollDate"];
  $role = $_POST["user_role"];

  $sql = "UPDATE `user` SET 
          `name`='$name',`password`='$password',`age`='$age', 
          `enrollDate`='$enrollDate',`roleId`='$role' WHERE id=$id";

  $result = $conn->query($sql);
  echo $sql;

  if ($result) {
    header("Location: ../pages/user.php");
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
          <label class="form-label">Tên người dùng:</label>
          <input type="text" class="form-control" required name="user_name" value="<?php echo $row['name'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Mật khẩu:</label>
          <input type="text" class="form-control" required name="user_password" value="<?php echo $row['password'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Tuổi:</label>
          <input type="text" class="form-control" required name="user_age" value="<?php echo $row['age'] ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Ngày tạo tài khoản:</label>
          <input type="date" class="form-control" required name="user_enrollDate" value="<?php echo date('Y-m-d', strtotime($row['enrollDate'])) ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Vai trò:</label>
          <select class="custom-select" id="roleSelect" required name="user_role" required valueToSelect="<?php echo $row['roleId'] ?>">
            <?php
            if ($roleId->num_rows > 0) {
              while ($row = $roleId->fetch_assoc()) {
                echo '<option value=' . $row['id'] . '>' . $row['roleName'] . '</option>';
              }
            }
            ?>
          </select>
        </div>

        <div class="mb-2 text-right">
          <button type="submit" class="btn btn-success" name="submit">Lưu</button>
          <a href="../pages/user.php" class="btn btn-danger">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</body>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var mySelect = document.getElementById("roleSelect");
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