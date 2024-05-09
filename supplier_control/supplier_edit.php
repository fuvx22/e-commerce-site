<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    include 'connect.php';

    // Thực hiện truy vấn để lưu dữ liệu vào cơ sở dữ liệu
    $sql = "UPDATE supplier 
    SET name = '$name', address = '$address', phone = '$phone', email = '$email'
    WHERE id = '$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Dữ liệu đã được lưu vào cơ sở dữ liệu.";
    } else {
        echo "Lỗi khi lưu dữ liệu: " . $conn->error;
    }

    $conn->close();
}
