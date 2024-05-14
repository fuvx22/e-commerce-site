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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include("../components/admin-menu.php") ?>
    <div class="container" style="padding: 0px 400px">
        <div class="p-5">
            <h1 class="text-center">Phiếu nhập</h1>
        </div>
        <div>
            <form method="post">
                <div class="">
                    <label for="name">Nhà cung cấp:*</label>
                    <select class="form-select" id="sel1">
                    </select>
                </div>
                <div class="mt-4">
                    <label for="name">Ngày tạo:*</label>
                    <input type="date" class="form-control" id="date">
                    <span class="small text-danger" id="message1"></span><br>
                </div>
                <div class="row" id="pro">
                    <label for="name">Sản phẩm:*</label>
                    <div class="col-9">
                        <select class="form-select" id="sel2">
                            <!-- <option selected>Product</option> -->
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="button" class="btn btn-success" value="Thêm" style="padding:6px 30px" id="btn1" onclick="addProduct()">
                    </div>
                    <span class="small text-danger" id="message3"></span><br>
                </div>
                <div>
                    <table class="table table-hover" id="tab">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tbo">
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a href="javascript:history.go(-1)" class="btn btn-outline-secondary mx-1" style="padding:7px 40px">Back</a>
                    <input class="btn btn-success" id="btn2" style="padding:7px 35px" type="button" value="Đồng ý" onclick="ok()">
                </div>
            </form>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        var productList = [];
        var id;

        // lấy data nhà cung cấp và set value cho nhà cung cấp
        function getSupplierData() {
            $.ajax({
                type: "GET",
                url: "supplier_data.php",
                dataType: "json",
                success: function(data) {
                    supData = data;
                    $.each(data, function(index, item) {
                        $('#sel1').append($('<option>', {
                            value: item.id + "&" + item.name,
                            text: item.id + " - " + item.name
                        }));
                    });
                }
            });
        }

        // lấy data sản phẩm và set value cho sản phẩm
        function getProductData() {
            $.ajax({
                type: "GET",
                url: "product_data.php",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(index, item) {
                        $('#sel2').append($('<option>', {
                            value: item.id + "&" + item.name,
                            text: item.id + " - " + item.name
                        }));
                    });
                }
            });
        }

        function getReceipt() {
            $.ajax({
                type: "GET",
                url: "receipt_data.php",
                dataType: "json",
                success: function(data) {
                    loadReceipt(data)
                }
            });
        }

        function loadReceipt(data) {
            for (var i = 0; i < data.length; i++) {
                if (id === data[i].id) {
                    $('#sel1').append($('<option>', {
                        value: data[i].id,
                        text: data[i].id + " - " + data[i].supplierName
                    }));
                    $('#date').val(data[i].enrollDate);
                    break;
                }
            }
        }

        function getReceiptline() {
            $.ajax({
                type: "GET",
                url: "receiptline_data.php",
                dataType: "json",
                success: function(data) {
                    loadReceiptline(data);
                }
            });
        }

        function loadReceiptline(data) {
            for (var i = 0; i < data.length; i++) {
                if (id === data[i].receiptId) {
                    var newRow = "<tr>";
                    newRow += "<td>" + data[i].productId + "</td>";
                    newRow += "<td>" + data[i].productName + "</td>";
                    newRow += "<td>" + data[i].quantity + "</td>";
                    newRow += "<td>  </td>";
                    newRow += "</tr>";
                    $("#tbo").append(newRow);
                }
            }
        }

        function addProduct() {
            var value = $("#sel2").val();
            value = value.split("&");
            var productId = decodeURIComponent(value[0]);
            var productName = decodeURIComponent(value[1]);
            var d = 1;
            for (var i = 0; i < productList.length; i++) {
                if (productId === productList[i]) {
                    alert("Sản phẩm này đã được thêm");
                    d = 0;
                    break;
                }
            }
            if (d === 1) {
                productList.push(productId);
                var newRow = "<tr>";
                newRow += "<td>" + productId + "</td>";
                newRow += "<td>" + productName + "</td>";
                newRow += "<td> <input name='quantity' class='form-control' type='number' value='1'> </td>";
                newRow += "<td> <input name='btnDel' class='btn btn-outline-secondary' type='button' value='delete'> </td>";
                newRow += "</tr>";
                $("#tbo").append(newRow);
            }
        }

        // bắt sự kiện cho các button
        function del() { // xóa
            $("#tab").on("click", "input[name='btnDel']", function() {
                var id = $(this).closest("tr").find("td:eq(0)").text(); // lấy id từ cột đầu tiên
                var index = productList.indexOf(id); // Tìm vị trí của phần tử có giá trị là 3 trong mảng
                productList.splice(index, 1); // Xóa phần tử tại vị trí index từ mảng

                // xóa hàng
                var row = $(this).closest("tr");
                row.remove();
            });
        }

        function crateId() {
            var currentDate = new Date();
            var id = (currentDate.getMinutes() + currentDate.getSeconds() + currentDate.getHours()) * (Math.floor(Math.random() * 100));
            return id;
        }

        function ok() { // thêm
            if (productList[0]) {
                //
                var c = 1;
                $('#tbo tr').each(function() {
                    var quantity = $(this).closest("tr").find("input[name='quantity']").val();
                    if (quantity < 1) {
                        c = 0;
                    }
                });
                //
                if (c === 1) {
                    var id = crateId();
                    var value = $("#sel1").val();
                    value = value.split("&");
                    var supplierId = decodeURIComponent(value[0]);
                    var supplierName = decodeURIComponent(value[1]);
                    var date = $("#date").val();
                    $.ajax({
                        type: "POST",
                        url: "receipt_add.php",
                        data: {
                            id: id,
                            supplierId: supplierId,
                            supplierName: supplierName,
                            date: date
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                    $('#tbo tr').each(function() {
                        var productId = $(this).closest("tr").find("td:eq(0)").text();
                        var productName = $(this).closest("tr").find("td:eq(1)").text();
                        var quantity = $(this).closest("tr").find("input[name='quantity']").val();
                        $.ajax({
                            type: "POST",
                            url: "receiptline_add.php",
                            data: {
                                receiptId: id,
                                productId: productId,
                                productName: productName,
                                quantity: quantity
                            },
                            success: function(response) {
                                console.log(response);
                            }
                        });
                    });
                    window.location.href = "../pages/receipt.php";
                } else {
                    alert("Số lượng phải lớn hơn 0");
                }
            } else {
                alert("Thêm ít nhất 1 sản phẩm");
            }
        }

        function getId() {
            var queryString = window.location.search; // lấy tham số truy vấn từ URL
            if (queryString) {
                queryString = queryString.substring(1); // loại bỏ dấu '?' ở đầu chuỗi tham số truy vấn
                var keyValue = queryString.split("="); // loại bỏ dấu =
                id = decodeURIComponent(keyValue[1]); // lấy valua thứ 1
                getReceipt();
                getReceiptline();
                $("#pro").hide();
                $("#btn2").hide();
            } else {
                getSupplierData();
                getProductData();
            }
        }

        function getDate() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Thêm 1 vào tháng vì tháng bắt đầu từ 0
            const dd = String(today.getDate()).padStart(2, '0');

            // Tạo chuỗi định dạng ngày
            const formattedDate = `${yyyy}-${mm}-${dd}`;
            document.getElementById('date').value = formattedDate;
        }

        $(document).ready(function() {
            del();
            getId();
            getDate();
        });
    </script>
</body>

</html>