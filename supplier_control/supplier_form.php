<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");

$conn = new Database();

$userAuth = new userAuth($conn);
$userAuth->checkReadPermission("2");

$isCreate = $userAuth->checkCreatePermission("2");
$isUpdate = $userAuth->checkUpdatePermission("2");
$isDelete = $userAuth->checkDeletePermission("2");

$products = $conn->query("SELECT p.*, s.name AS sname FROM product AS p JOIN subcategory AS s ON p.subcategoryId = s.id ORDER BY id DESC");

$conn->close();

// Định dạng số với dấu chấm phân cách hàng đơn vị
function formatNumber($number)
{
    return number_format($number, 0, ',', '.');
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include("../components/admin-menu.php") ?>
    <div class="container">
        <div class="p-5">
            <h1 class="text-center">Nhà cung cấp</h2>
        </div>
        <div style="padding: 0px 400px">
            <form method="post">
                <div>
                    <label for="name">Tên:*</label>
                    <input type="text" class="form-control" name="name" id="name">
                    <span class="small text-danger" id="message1"></span><br>
                </div>
                <div class="mb-4">
                    <label for="name">Địa chỉ:</label>
                    <input type="text" class="form-control" name="address" id="address">
                </div>
                <div class="">
                    <label for="name">Số điện thoại:*</label>
                    <input type="text" class="form-control" name="phone" id="phone">
                    <span class="small text-danger" id="message2"></span><br>
                </div>
                <div class="">
                    <label for="name">Email:*</label>
                    <input type="text" class="form-control" name="email" id="email">
                    <span class="small text-danger" id="message3"></span><br>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a href="javascript:history.go(-1)" class="btn btn-outline-secondary mx-1" style="padding:7px 40px">Back</a>
                    <input class="btn btn-success" style="padding:7px 35px" type="button" value="Đồng ý" onclick="check()">
                </div>
            </form>
        </div>
    </div>
    <script>
        var id = '';

        function check() {
            var name = $("#name").val();
            var address = $("#address").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var count = 0;

            // Kiểm tra rỗng
            if (name === '') {
                $("#message1").text("Nhập tên.");
            } else {
                $("#message1").text("");
                count += 1;
            }

            if (phone === '') {
                $("#message2").text("Nhập tên.");
            } else {
                var phonePattern = /^(\+?84|0)(3[2-9]|5[2-9]|7[06-9]|8[1-9]|9[0-9])[0-9]{7}$/;
                if (phonePattern.test(phone)) {
                    $("#message2").text("");
                    count += 1;
                } else {
                    $("#message2").text("Số điện thoại không đúng.");
                }
            }

            if (email != '') {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailPattern.test(email)) {
                    $("#message3").text("");
                    count += 1;
                } else {
                    $("#message3").text("Email không hợp lệ.");
                }
            } else {
                $("#message3").text("Nhập tên.");
            }

            if (count === 3) {
                if (id === '') { // nếu id rỗng thì thêm
                    add(name, address, phone, email);
                    window.location.href = "../pages/supplier.php";
                } else {
                    edit(name, address, phone, email);
                    window.location.href = "../pages/supplier.php";
                }
            }

        }

        function getId() {
            // lấy tham số truy vấn từ URL
            var queryString = window.location.search;
            if (queryString) {
                // loại bỏ dấu '?' ở đầu chuỗi tham số truy vấn
                queryString = queryString.substring(1);
                var keyValue = queryString.split("="); // loại bỏ dấu =
                id = decodeURIComponent(keyValue[1]); // lấy valua thứ 1
                getData();
            }
        }

        function add(name, address, phone, email) {
            $.ajax({
                type: "POST",
                url: "supplier_add.php",
                data: {
                    name: name,
                    address: address,
                    phone: phone,
                    email: email
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }

        function edit(name, address, phone, email) {
            $.ajax({
                type: "POST",
                url: "supplier_edit.php",
                data: {
                    id: id,
                    name: name,
                    address: address,
                    phone: phone,
                    email: email
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }

        function getData() {
            $.ajax({
                type: "GET",
                url: "supplier_data.php",
                dataType: "json",
                success: function(response) {
                    loadData(response);
                }
            });
        }

        function loadData(data) {
            for (var i = 0; i < data.length; i++) {
                if (id === data[i].id) {
                    $("#name").val(data[i].name);
                    $("#address").val(data[i].address);
                    $("#phone").val(data[i].phone);
                    $("#email").val(data[i].email);
                }
            }
        }

        $(document).ready(function() {
            getId();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>