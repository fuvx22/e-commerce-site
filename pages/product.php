<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");

$conn = new Database();

$userAuth = new userAuth($conn);
$userAuth->checkReadPermission("2");

$isCreate = $userAuth->checkCreatePermission("2");
$isUpdate = $userAuth->checkUpdatePermission("2");
$isDelete = $userAuth->checkDeletePermission("2");

$products = $conn->query("SELECT p.*, s.name AS sname FROM product AS p JOIN subcategory AS s ON p.subcategoryId = s.id ORDER BY id DESC");

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
  <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <script defer src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php include("../components/admin-menu.php") ?>
  <div class="container">
    <div class="col mt-2 ms-2">
      <h3>Quản lý sản phẩm</h3>
    </div>
    <div class="container my-3">
      <?php
      if ($isCreate) {
        echo '<a href="../product_control/add_new.php" class="btn btn-success">Thêm sản phẩm</a>';
      } else {
        echo '<button class="btn btn-dark" disabled>Thêm sản phẩm</button>';
      }
      ?>
    </div>
    <div class="container">
      <?php
      if (isset($_SESSION["product_msg"])) {
        $msg = $_SESSION["product_msg"];
        echo '
        <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
          . $msg .
          '
        </div>';
        unset($_SESSION["product_msg"]);
      }
      ?>
      <table class="table text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Id</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Thể loại</th>
            <th scope="col">Giá</th>
            <th scope="col">Số lượng</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($products->num_rows > 0) {
            $count = 0;
            while ($row = $products->fetch_assoc()) {
              $count++;
          ?>
              <tr>
                <th scope="row"><?php echo $count ?></th>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['image'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['sname'] ?></td>
                <td><?php echo formatNumber($row['price']) ?>đ</td>
                <td><?php echo $row['quantity'] ?></td>
                <td style="min-width: 100px;">
                  <a <?= $isUpdate ? "" : "hidden" ?> href="../product_control/edit.php?id=<?= $row['id'] ?>" style="text-decoration: none">
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
      document.location.href = "../product_control/delete.php?id=" + idToDelete;
    }
  }

  setTimeout(function() {
    var alert = document.getElementById('myAlert');
    var bsAlert = new bootstrap.Alert(alert);
    bsAlert.close();
  }, 3000);
</script>


</html>