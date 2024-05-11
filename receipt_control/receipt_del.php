<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    include 'connect.php';

    $sql = "DELETE FROM receipt WHERE id = '$id'";
    
    $conn->query($sql);

    $conn->close();
}

?>