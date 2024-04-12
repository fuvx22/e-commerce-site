<?php
require_once("../db_connect.php");

$conn = new Database();

$categories = $conn->query("SELECT * FROM category ORDER BY id DESC");
$sub_categories = $conn->query("SELECT *,s.id AS id, category_name FROM subcategory as s JOIN category AS c ON s.categoryId = c.id  ORDER BY s.id DESC");

$conn->close();

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
  <div class="container">
    <div class="container">
      <h3>Quản lý danh mục và sản phẩm</h3>

      <?php
      session_start();
      if (isset($_SESSION["subcategory_msg"])) {
        $msg = $_SESSION["subcategory_msg"];
        echo '
        <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
          . $msg .
          '<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        unset($_SESSION["subcategory_msg"]);
      }
      ?>

      <div class="d-flex justify-content-between">
        <a href="../category_control/addcategory.php" class="btn btn-success my-2">Thêm mới danh mục</a>
        <a href="../category_control/addsubcategory.php" class="btn btn-success my-2 ms-5">Thêm mới thể loại</a>
      </div>


      <div class="d-flex">
        <table class="table text-center col-sm-6">
          <thead class="table-dark">
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Id</th>
              <th scope="col" style="min-width: 140px;">Tên danh mục</th>
              <th scope="col">Mô tả</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($categories->num_rows > 0) {
              $count = 0;
              while ($row = $categories->fetch_assoc()) {
                $count++;
            ?>
                <tr>
                  <th scope="row"><?php echo $count ?></th>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['category_name'] ?></td>
                  <td><?php echo $row['description'] ?></td>
                  <td style="min-width: 100px;">
                    <a href="../category_control/editcategory.php?id=<?php echo $row['id'] ?>" style="text-decoration: none;">
                      <i class="fa-solid fa-pen-to-square fs-5 mx-1"></i>
                    </a>
                    <a idToDelete="<?php echo $row['id'] ?>" type="category" class="text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
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
        <table class="table text-center col-sm-6 mx-1">
          <thead class="table-dark">
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Id</th>
              <th scope="col">Tên thể loại</th>
              <th scope="col">Danh mục thể loại</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($sub_categories->num_rows > 0) {
              $count = 0;
              while ($row = $sub_categories->fetch_assoc()) {
                $count++;
            ?>
                <tr>
                  <th scope="row"><?php echo $count ?></th>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['name'] ?></td>
                  <td><?php echo $row['category_name'] ?></td>
                  <td style="min-width: 100px;">
                    <a href="../category_control/editsubcategory.php?id=<?php echo $row['id'] ?>" style="text-decoration: none;">
                      <i class="fa-solid fa-pen-to-square fs-5 mx-1"></i>
                    </a>
                    <a idToDelete="<?php echo $row['id'] ?>" type="subcategory" class="text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
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
  var deleteHref = "";
  confirmDeleteModal.addEventListener("show.bs.modal", (event) => {
    var button = event.relatedTarget;
    idToDelete = button.getAttribute('idToDelete')
    typeToDelete = button.getAttribute('type')

    var modalBody = confirmDeleteModal.querySelector(".modal-body");

    deleteHref = "../category_control/delete.php?type=" + typeToDelete;
    if (typeToDelete === "category") {
      modalBody.textContent = "Bạn có chắc chắn muốn xóa danh mục này?";
    } else {
      modalBody.textContent = "Bạn có chắc chắn muốn xóa thể loại này?";
    }
  })

  const handleConfirmDelete = () => {
    if (idToDelete != -1) {
      document.location.href = deleteHref + "&id=" + idToDelete;
    }
  }

  setTimeout(function() {
    var alert = document.getElementById('myAlert');
    var bsAlert = new bootstrap.Alert(alert);
    bsAlert.close();
  }, 3000);
</script>


</html>