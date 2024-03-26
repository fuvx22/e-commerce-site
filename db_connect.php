<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_cuahangthoitrang";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
