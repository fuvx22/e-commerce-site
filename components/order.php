
<?php
$conn = new Database();
$products = $conn->query("SELECT * FROM order, user WHERE order.userld=user.id ORDER BY id DESC");
$conn->close();
// Định dạng số với dấu chấm phân cách hàng đơn vị
function formatNumber($number)
{
  return number_format($number, 0, ',', '.');
}
?>
<html>
    <body>
    <table class="table text-center">
        <thead class="table-dark">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">ten khach </th>
            <th scope="col">dien thoai</th>
            <th scope="col">email</th>
            <th scope="col">trang thai</th>
            <th scope="col">chi tiet don hang</th>
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
                <td><?php echo $row['email'] ?></td>
                <td><?php if($row['status']==1) {
                            echo '<a href="xuly.php?cartID=' .$row['id'].'">Dang xu li</a>';
                } else{
                    echo "Da xu li";
                }
                ?>
              </td>
                <td><a href="">xem don hang</a></td>
              </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </body>
</html>