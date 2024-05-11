<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name =  $_POST['name'];
    $address =  $_POST['address'];
    $phone =  $_POST['phone'];
    $email =  $_POST['email'];

    include 'connect.php';

    $sql = "INSERT INTO supplier (name, address, phone, email) VALUES ('$name', '$address', '$phone', '$email')";
    $conn->query($sql);
    
    $conn->close();
}
