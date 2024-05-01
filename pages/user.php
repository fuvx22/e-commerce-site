<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
require_once("../utils/user-auth.php");
$database = new Database();

$userAuth = new userAuth($database);
$userAuth->checkReadPermission("5");
$isUpdate = $userAuth->checkUpdatePermission("5");
$isDelete = $userAuth->checkDeletePermission("5");

$users = $database->query("SELECT * FROM user");
$database->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
  <?php include("../components/admin-menu.php") ?>
  <div class="container">
    <div class="col my-1">
      <h3>Quản lý tài khoản</h3>
    </div>
    <table class="table text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Id</th>
          <th scope="col">Tên tài khoản</th>
          <th scope="col">Email</th>
          <th scope="col">Mật Khẩu</th>
          <th scope="col">RoleID</th>
          <th scope="col">Tuổi</th>
          <th scope="col">Ngày tạo tài khoản</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($users->num_rows > 0) {
          $count = 0;
          while ($row = $users->fetch_assoc()) {
            $count++;
        ?>
            <tr>
              <th scope="row"><?php echo $count ?></th>
              <td><?php echo $row['id'] ?></td>
              <td><?php echo $row['name'] ?></td>
              <td><?php echo $row['email'] ?></td>
              <td><?php echo $row['password'] ?></td>
              <td><?php echo $row['roleId'] ?></td>
              <td><?php echo $row['age'] ?></td>
              <td><?php echo $row['enrollDate'] ?></td>
              <td style="min-width: 100px;">
                <a <?= $isUpdate ? "" : "hidden" ?> href="../user_control/edit.php?id=<?php echo $row['id'] ?>" style="text-decoration: none;">
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
          <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          Bạn có chắc chắn muốn xóa sản phẩm này?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
          <button type="button" class="btn btn-danger" onclick="handleConfirmDelete()" data-bs-dismiss="modal">Có</button>
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
      document.location.href = "../user_control/delete.php?id=" + idToDelete;
    }
  }

  setTimeout(function() {
    var alert = document.getElementById('myAlert');
    var bsAlert = new bootstrap.Alert(alert);
    bsAlert.close();
  }, 3000);
</script>


</html>