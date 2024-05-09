<?php
include 'connect.php';

$sql = "SELECT * FROM receiptline";
$result = $conn->query($sql);

// Mảng để lưu trữ dữ liệu từ cơ sở dữ liệu
$data = array();

// Lặp qua từng hàng dữ liệu và thêm vào mảng
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($data);

$conn->close();
?>