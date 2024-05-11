<?php
require_once ("../db_connect.php ");
$conn= new Database();
$sql="SELECT * FROM payment";
$payment= $conn->query($sql);
$conn->close();
?>
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
      <h3>Quản lý thanh toán</h3>
    </div>
    <div class="container">
      <table class="table text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">Mã hóa đơn</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col">Ngày thanh toán</th>
            <th scope="col">Mã nhân viên</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($payment->num_rows > 0) {
            $count = 0;
            while ($row = $payment->fetch_assoc()) {
              $count++;
          ?>
              <tr>
                <td><?php echo $row['orderId'] ?></td>
                <td><?php echo $row['total']?>đ</td>
                <td><?php echo $row['paymentDate'] ?></td>
                <td><?php echo $row['employeeId'] ?></td>
              </tr> 
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>

   
</body>
</html>