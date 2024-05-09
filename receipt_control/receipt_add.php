<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $supplierId = $_POST['supplierId'];
    $supplierName = $_POST['supplierName'];
    $enrollDate = $_POST['date'];

    include 'connect.php';

    $sql = "INSERT INTO receipt (id, supplierId, supplierName, enrollDate) VALUES ('$id', '$supplierId', '$supplierName', '$enrollDate')";

    $conn->query($sql);

    $conn->close();
}
