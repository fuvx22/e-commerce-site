<?php

include 'connect.php';

// Truy vấn cơ sở dữ liệu để lấy dữ liệu danh sách
$sql = "SELECT * FROM supplier";
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

// Đóng kết nối
$conn->close();
