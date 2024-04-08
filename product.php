<?php
require_once("db_connect.php");

$conn = new Database();

$products = $conn->query("SELECT p.*, s.name AS sname FROM product AS p JOIN subcategory AS s ON p.subcategoryId = s.id");

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="col my-1">
      <h3>Quản lý sản phẩm</h3>
    </div>
    <div class="container">
      <a href="./product_control/add_new.php" class="btn btn-success my-2">Thêm sản phẩm</a>
    </div>
    <div class="container">
      <?php
      session_start();
      if (isset($_SESSION["product_msg"])) {
        $msg = $_SESSION["product_msg"];
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">'
          . $msg .
          '<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td style="min-width: 100px;">
                  <a href="./product_control/edit.php?id=<?php echo $row['id'] ?>">
                    <i class="fa-solid fa-pen-to-square fs-5 mx-1"></i>
                  </a>
                  <a onclick="confirmDelete(<?php echo $row['id'] ?>)" class="text-danger">
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
</body>

<script>
  const confirmDelete = (id) => {
    sts = confirm("Bạn có chắc chắn muốn xóa sản phẩm này");
    if (sts) {
      document.location.href = './product_control/delete.php?id=' + id;
    }
  }
</script>


</html>