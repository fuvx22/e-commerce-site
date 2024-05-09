<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    include 'connect.php';

    $sql = "DELETE FROM supplier WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Dữ liệu đã được lưu vào cơ sở dữ liệu.";
    } else {
        echo "Lỗi khi lưu dữ liệu: " . $conn->error;
    }
    // Đóng kết nối
    $conn->close();
}
