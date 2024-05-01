<?php
require_once('../db_connect.php');
require_once("../utils/user-auth.php");
$conn = new Database();
$userAuth = new userAuth($conn);
$isCreate = $userAuth->checkCreatePermission("7");

if (!$isCreate) {
  header("Location: ../pages/role.php");
  exit();
}
$features_list = $conn->query("SELECT * FROM chucnang");
$conn->close();

if (isset($_POST['submit'])) {
  // Connect to your database
  $conn = new Database();

  // Retrieve the role name from the $_POST array
  $role_name = $_POST['role_name'];

  // Insert the new role into the roles table
  $sql = "INSERT INTO role (roleName) VALUES ('$role_name')";

  $role_id = $conn->insert($sql);

  // Retrieve the selected actions for each feature from the $_POST['features'] array
  $features = $_POST['features'];

  // Loop through the selected actions for each feature
  foreach ($features as $feature_id => $actions) {
    // For each action, insert a new row into the role-feature-action relationship table
    foreach ($actions as $action) {
      $sql = "INSERT INTO role_chucnang (roleId, chucnangId, action) VALUES ('$role_id', '$feature_id', '$action')";
      $conn->insert($sql);
    }
  }
  $conn->close();

  session_start();
  $_SESSION["role_msg"] = "Thêm quyền mới thành công";
  header("Location: ../pages/role.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/phu.css">
</head>

<body>
  <h3 class="text-center my-3">Thêm quyền mới</h3>
  <div class="container-md">
    <form action="../role_control/add-role.php" method="post">
      <div class="form-group">
        <label for="role_name">Tên quyền</label>
        <input type="text" class="form-control" id="role_name" name="role_name" required>
      </div>
      <label class="mt-2">Chọn chức năng cho quyền:</label>
      <div class="d-md-flex justify-content-between">
        <?php
        if ($features_list->num_rows > 0) {
          while ($feature = $features_list->fetch_assoc()) {
            echo '
            <div class="form-group py-2 border role-action-checkbox">
              <label>' . $feature['name'] . '</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'c" name="features[' . $feature['id'] . '][]" value="create">
              <label for="feature' . $feature['id'] . 'c">Thêm</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'u" name="features[' . $feature['id'] . '][]" value="update">
              <label for="feature' . $feature['id'] . 'u">Sửa</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'd" name="features[' . $feature['id'] . '][]" value="delete">
              <label for="feature' . $feature['id'] . 'd">Xóa</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'r" name="features[' . $feature['id'] . '][]" value="read">
              <label for="feature' . $feature['id'] . 'r">Xem</label><br>
            </div>';
          }
        }
        ?>
      </div>
      <div class="d-flex justify-content-end my-2">
        <a href="../pages/role.php" class="btn btn-danger mx-2 px-3">Hủy</a>
        <button name="submit" class="btn btn-success">Thêm</button>
      </div>
    </form>
  </div>
</body>

</html>