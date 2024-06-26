<?php
session_start();
 require_once("../db_connect.php");
 require_once("../utils/user-auth.php");
 require_once("../model/orderModel.php");
 
 $conn = new Database();
 
 $userAuth = new userAuth($conn);
 $userAuth->checkReadPermission("2");
 
 $isCreate = $userAuth->checkCreatePermission("2");
 $isUpdate = $userAuth->checkUpdatePermission("2");
 $isDelete = $userAuth->checkDeletePermission("2");
 if($_SERVER["REQUEST_METHOD"] == "GET"){
    $orderId = $_GET["id"];
    $order = orderModel::getOrderByIdOrder($orderId);
    $productOrder = orderModel::getProductByOrderId($orderId);
    $payment = null;
    $sql = "SELECT * FROM `payment` WHERE orderId = '$orderId'";
    $result = $conn -> query($sql);
    if($result -> num_rows > 0){
        $payment = $result -> fetch_assoc();
    }
 }

 if (isset($_POST["submit"])) {
    if(isset($_SESSION['userData'])){
        $orderId = intval($_GET["id"]);
        // print_r($_SESSION['userData']['id']);
        $total = $_POST["totalAmount"];
        $paymentDate = date("Y-m-d");
        $employeeId = $_SESSION['userData']['id'];
        $sql = "INSERT INTO `payment` (orderId, total, paymentDate, employeeId) 
        VALUES ('$orderId', '$total', '$paymentDate', '$employeeId')";
        $result = $conn -> query($sql);
        if($result){
            $_SESSION['paymentOrder_msg'] = "Thanh Toán Đơn Hàng Thành Công";
            $order = orderModel::getOrderByIdOrder($orderId);
            $productOrder = orderModel::getProductByOrderId($orderId);
            $sql = "SELECT * FROM `payment` WHERE orderId = '$orderId'";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                $payment = $result -> fetch_assoc();
            }
        }
    } 
 }
 $conn->close();

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
        <h3>Quản Lí Chi Tiết Đơn Hàng</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <strong>Thông Tin Đơn Hàng</strong>
                </div>
                <?php
                 if (isset($_SESSION["paymentOrder_msg"])) {
                    $msg = $_SESSION["paymentOrder_msg"];
                    echo '
                    <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
                    . $msg .
                    '
                    </div>';
                    unset($_SESSION["paymentOrder_msg"]);
                //    echo "Xuất thông báo";
                }
                if (isset($_SESSION["orderUpdateStatus_msg"])) {
                    $msg = $_SESSION["orderUpdateStatus_msg"];
                    echo '
                    <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
                    . $msg .
                    '
                    </div>';
                    unset($_SESSION["orderUpdateStatus_msg"]);
                }
                if (isset($_SESSION["orderUpdateShippedDate_msg"])) {
                    $msg = $_SESSION["orderUpdateShippedDate_msg"];
                    echo '
                    <div id="myAlert" class="alert alert-success alert-dismissible fade show" role="alert">'
                    . $msg .
                    '
                    </div>';
                    unset($_SESSION["orderUpdateShippedDate_msg"]);
                }
                ?>
                <div class="card-body">
                    <p>Mã đơn hàng: <strong><?php echo $order['id']?></strong> </p>
                    <p>Ngày đặt: <strong><?php 
                     $date = DateTime::createFromFormat('Y-m-d', $order['enrollDate']);
                    echo $date->format('d/m/Y'); 
                    ?></strong> </p>
                    <p>Ngày Đã Giao Hàng: <strong><?php
                   if($order['shippedDate'] != null){
                    $date = DateTime::createFromFormat('Y-m-d', $order['shippedDate']);
                    $formattedDate = $date->format('Y-m-d');
                    echo $date->format('d/m/Y');;
                    }else {
                        if($order['status'] === "Đã Xử Lý"){
                            echo "<i class='fa fa-edit' id='edit-icon' onclick='handleEditDate()'></i>";
                            echo "<form action='/e-commerce-site/controller/editShippedDateController.php' method='post'>";
                            echo "<input type='date' name='shippedDate' id='select-date' style='display: none;'> ";
                            echo "<input type='hidden' name='orderId' value='" . $order['id'] . "'>";
                            echo "<button type='submit' class='btn btn-success' id='save-date' style='display: none;'>Lưu</button>";
                            echo "</form>";
                        }
                        else{
                            echo "<p>Bạn Cần phải cập nhật đơn hàng</p>";
                        }
                        
                    }
                    ?></strong> </p>
                    <div class="mb-2">
                        <form action="/e-commerce-site/controller/editOrderedStatusController.php" method="post">
                        <span>Trạng Thái: </span>
                        <select name="statusSelected" id="select-status" disabled>
                            <option value="Chờ Xử Lý" <?php echo $order['status'] == 'Chờ Xử Lý' ? 'selected' : ''; ?>>Chờ Xử Lý</option>
                            <option value="Đã Xử Lý" <?php echo $order['status'] == 'Đã Xử Lý' ? 'selected' : ''; ?>>Đã Xử Lý</option>
                        </select>
                        <input type="hidden" name="orderId" value="<?php echo $order['id']; ?>">
                        <button class=" btn btn-danger " id="btn-save-status" style="display: none;">Lưu Trạng Thái</button>
                        </form>
                        
                    </div>
                    <p>Địa chỉ: <strong><?php echo $order['address'] ?></strong> </p>
                    <p>Số điện thoại: <strong><?php echo $order['phoneNumber'] ?></strong> </p>
                    <p>Ghi chú: <strong><?php echo $order['description'] ?></strong> </p>
                    <div class="d-flex flex-column">
                        <div class="d-flex mb-4 justify-content-between">
                        <button class=" btn btn-success mr-2 " onclick="editStatus() <?php echo $payment ? 'disabled' : '';  ?>">Sửa Trạng Thái</button>
                        </div>
                        <button class=" btn btn-outline-dark w-50" onclick="cancleEdit()">Hủy</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Danh sách sản phẩm</strong>
                </div>
                <div class="card-body">
                    <div class="list-group ">
                    <?php if(is_array($productOrder)):  $total = 0; ?>
                        <?php foreach($productOrder as $product): ?>
                            <?php $total += $product['price'] * $product['quantity'];?>
                            <div class=" mb-3 border  rounded list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                <img src="<?php echo $product['image']?>" class="img-thumbnail me-3 product-image" style="width: 60px; height: 60px;">
                                    <div>
                                        <p>Tên sản phẩm: <a class="text-decoration-none text-black" href="/e-commerce-site/pages/product_details.php?id=<?php echo $product['id']?>"><strong><?php echo $product['name']?></strong></a> </p>
                                        <p>Số lượng: <strong><?php echo $product['quantity']?></strong></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                <span >Giá: <strong class="product-price"><?php echo number_format((float)$product['price'], 0, '.', ',')?></strong> VNĐ</span>                               
                             </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không tìm thấy đơn hàng nào.</p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <span class="total-amount" name="totalAmout"><strong><?php echo number_format((float)$total, 0, '.', ',')?></strong> VNĐ</span>
                    </div>
                </div>
            </div>
            <div class=" mt-4 d-flex justify-content-end">
            <form action="" method="post">
                    <input type="text" hidden name="totalAmount" value="<?php echo $total?>">
                    <?php
                    if($order['shippedDate'] == null){
                        echo "Đơn Hàng Chưa được giao! Không thể thanh toán";
                    }
                    else{
                        echo $payment ? "<p class=\"text-primary fs-5\">Đã thanh toán</p>" : '<button type="submit" name="submit" class="btn btn-success">Thanh Toán Đơn Hàng</button>';
                    }
                    
                     ?>                    
                </form>
             
            </div>                
        </div>
    </div>

</div>
</body>
<script>
    const selectStatus = document.getElementById("select-status");
    const saveStatus = document.getElementById("btn-save-status");
    const editIcon = document.getElementById("edit-icon");
    const selectDate = document.getElementById("select-date");
    const saveDate = document.getElementById("save-date");
    function editStatus(){
        selectStatus.disabled = false;
        saveStatus.style.display = "inline-block";
    }
    function cancleEdit(){ 
        selectStatus.disabled = true;
        saveStatus.style.display = "none";
        selectDate.style.display = "none";
        saveDate.style.display = "none";
    }
    function handleEditDate() {
        selectDate.style.display = 'block';
        saveDate.style.display = 'block';
    }
//     document.addEventListener("DOMContentLoaded", function() {
//   var unsubmitButton = document.querySelector("button[name='unsubmit']");

//   // Kiểm tra trạng thái đã thanh toán trong localStorage
//   var isPaid = localStorage.getItem("isPaid");
//   if (isPaid && isPaid === "true") {
//     unsubmitButton.style.display = "block";
//   }
// });
    function paymentOrder(){
        //event.preventDefault(); 
        document.getElementsByName('submit')[0].style.display = "none";
    document.getElementsByName('unsubmit')[0].style.display = "block";
    //localStorage.setItem("isPaid", "true");            
       
    }
   

</script>
</html> 