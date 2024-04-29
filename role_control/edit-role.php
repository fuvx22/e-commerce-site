<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");
$conn = new Database();

$userAuth = new userAuth($conn);
$isUpdate = $userAuth->checkUpdatePermission("7");

if (!$isUpdate) {
  header("Location: ../pages/role.php");
  exit();
}
$features_list = $conn->query("SELECT * FROM chucnang");

if (isset($_POST['submit'])) {
  // Connect to your database
  $conn = new Database();

  $role_id = $_GET['id'];

  // Retrieve the role name from the $_POST array
  $role_name = $_POST['role_name'];

  // Update the role name in the roles table
  $sql = "UPDATE role SET roleName = '$role_name' WHERE id = $role_id";
  $conn->query($sql);

  // Retrieve the selected actions for each feature from the $_POST['features'] array
  $features = $_POST['features'];

  // Delete all existing role-feature-action relationships for the current role
  $sql = "DELETE FROM role_chucnang WHERE roleId = $role_id";
  $conn->query($sql);

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
  $_SESSION["role_msg"] = "Chỉnh sửa quyền thành công";
  header("Location: ../pages/role.php");
  exit();
}

$role_id = $_GET['id'];
$role = $conn->query("SELECT * FROM role WHERE id = $role_id")->fetch_assoc();

if (!$role) {
  echo 'Role not found';
  exit();
}

$sql = "SELECT chucnangId, action FROM role_chucnang WHERE roleId = $role_id";
$role_features_actions = $conn->query($sql);

// Convert the result to an associative array
$role_features_actions_assoc = [];
while ($row = $role_features_actions->fetch_assoc()) {
  $role_features_actions_assoc[$row['chucnangId']][] = $row['action'];
}
$conn->close();

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
  <h3 class="text-center my-3">Chỉnh sửa quyền</h3>
  <div class="container-md">
    <form action="../role_control/edit-role.php?id=<?= $role_id ?>" method="post">
      <div class="form-group">
        <label for="role_name">Tên quyền: </label>
        <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo $role['roleName'] ?>" required>
      </div>
      <label class="mt-2">Chọn chức năng cho quyền: </label>
      <div class="d-md-flex justify-content-between">
        <?php
        if ($features_list->num_rows > 0) {
          while ($feature = $features_list->fetch_assoc()) {
            echo '
            <div class="form-group py-2 border role-action-checkbox">
              <b>' . $feature['name'] . '</b><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'c" name="features[' . $feature['id'] . '][]" value="create"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('create', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '>
              <label for="feature' . $feature['id'] . 'c">Thêm</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'u" name="features[' . $feature['id'] . '][]" value="update"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('update', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '>
              <label for="feature' . $feature['id'] . 'u">Sửa</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'd" name="features[' . $feature['id'] . '][]" value="delete"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('delete', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '>
              <label for="feature' . $feature['id'] . 'd">Xóa</label><br>
              <input type="checkbox" id="feature' . $feature['id'] . 'r" name="features[' . $feature['id'] . '][]" value="read"' . (isset($role_features_actions_assoc[$feature['id']]) && in_array('read', $role_features_actions_assoc[$feature['id']]) ? ' checked' : '') . '>
              <label for="feature' . $feature['id'] . 'r">Xem</label><br>
            </div>';
          }
        }
        ?>
      </div>
      <div class="d-flex justify-content-end my-2">
        <a href="../pages/role.php" class="btn btn-danger mx-2">Hủy</a>
        <button name="submit" class="btn btn-success">Lưu</button>
      </div>
    </form>
  </div>
</body>

</html>