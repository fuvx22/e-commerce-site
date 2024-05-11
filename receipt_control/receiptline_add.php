<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $receiptId = $_POST['receiptId'];
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];

    include 'connect.php';

    // thêm vào db receiptline
    $sql1 = "INSERT INTO receiptline (receiptId, productId, productName, quantity) VALUES ('$receiptId', '$productId', '$productName', '$quantity')";
    $conn->query($sql1);
    
    // lấy số lượng hiện tại
    $sql2 = "SELECT quantity FROM product WHERE id = '$productId'";
    $result = $conn->query($sql2);
    $row = $result->fetch_assoc();
    $oldQuantity = $row["quantity"];
    $quantity = $quantity + $oldQuantity;

    // thêm số lượng mới
    $sql3 = "UPDATE product 
    SET quantity = '$quantity'
    WHERE id = '$productId'";
    $conn->query($sql3);

    $conn->close();
}
?>