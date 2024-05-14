<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");

$conn = new Database();

$userAuth = new userAuth($conn);
$userAuth->checkReadPermission("7");

$isCreate = $userAuth->checkCreatePermission("7");
$isUpdate = $userAuth->checkUpdatePermission("7");
$isDelete = $userAuth->checkDeletePermission("7");

$role = $conn->query("SELECT * FROM role");

$conn->close();

// Định dạng số với dấu chấm phân cách hàng đơn vị
function formatNumber($number)
{
  return number_format($number, 0, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../css/phu.css">
  <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <script defer src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include("../components/admin-menu.php") ?>
  <div class="container">
    <div class="p-5">
      <h1 class="text-center">Quản lý quyền</h1>
    </div>
    <div class="container mb-1">
      <?php
      if ($isCreate) {
        echo '<a href="../role_control/add-role.php" class="btn btn-success">Thêm quyền mới</a>';
      } else {
        echo '<button class="btn btn-dark" disabled>Thêm quyền mới</button>';
      }
      ?>
    </div>
    <div class="container">
      <?php
      if (isset($_SESSION["role_msg"])) {
        $msg = $_SESSION["role_msg"];
        echo '
        <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
          . $msg .
          '</div>';
        unset($_SESSION["role_msg"]);
      }
      ?>
      <table class="table text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Id</th>
            <th scope="col">Tên quyền</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($role->num_rows > 0) {
            $count = 0;
            while ($row = $role->fetch_assoc()) {
              $count++;
          ?>
              <tr>
                <th scope="row"><?php echo $count ?></th>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['roleName'] ?></td>
                <td><button class="btn btn-dark view-role" data-role-id="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#viewRoleModal">Xem quyền</button></td>
                <td style="min-width: 120px;">
                  <a <?= $isUpdate ? "" : "hidden" ?> href="../role_control/edit-role.php?id=<?= $row['id'] ?>" style="text-decoration: none;">
                    <i class="fa-solid fa-pen-to-square fs-5 mx-1"></i>
                  </a>
                  <a <?= $isDelete ? "" : "hidden" ?> idToDelete="<?php echo $row['id'] ?>" class="text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    <i class="fa-solid fa-trash fs-5 mx-1"></i>
                  </a>
                </td>
              </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <i class="fa-solid fa-circle-exclamation"></i>
              Lưu ý
            </h5>
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Bạn có chắc chắn muốn xóa quyền này này?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
            <button type="button" class="btn btn-danger" onclick="handleConfirmDelete()" data-bs-dismiss="modal">Có</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewRoleModalLabel">Chi tiết quyền</h5>
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-striped border">
              <thead>
                <tr>
                  <th scope="col">Chức năng</th>
                  <th scope="col">Thêm</th>
                  <th scope="col">Sửa</th>
                  <th scope="col">Xóa</th>
                  <th scope="col">Xem</th>
                </tr>
              </thead>
              <tbody id="roleFeaturesActions">
                <!-- The features and actions will be inserted here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</body>

<script>
  var idToDelete = -1;
  var confirmDeleteModal = document.getElementById("confirmDeleteModal");
  confirmDeleteModal.addEventListener("show.bs.modal", (event) => {
    var button = event.relatedTarget;
    idToDelete = button.getAttribute('idToDelete')
  })

  const handleConfirmDelete = () => {
    if (idToDelete != -1) {
      document.location.href = "../role_control/delete-role.php?id=" + idToDelete;
    }
  }

  setTimeout(function() {
    var alert = document.getElementById('myAlert');
    if (alert == null) return;
    var bsAlert = new bootstrap.Alert(alert);
    bsAlert.close();
  }, 3000);

  document.querySelectorAll('.view-role').forEach(button => {
    button.addEventListener('click', function() {
      const roleId = this.dataset.roleId;

      // Fetch the features and actions for the role from the server
      fetch(`../role_control/view-role.php?role_id=${roleId}`)
        .then(response => response.json())
        .then(data => {

          // Populate the table with the fetched data
          document.getElementById('roleFeaturesActions').innerHTML = data;
        });
    });
  });
</script>


</html>