<?php
require_once("../db_connect.php");
require_once("../utils/user-auth.php");

$conn = new Database();

$userAuth = new userAuth($conn);
$userAuth->checkReadPermission("6");

$isCreate = $userAuth->checkCreatePermission("6");
$isUpdate = $userAuth->checkUpdatePermission("6");
$isDelete = $userAuth->checkDeletePermission("6");


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
    <div class="container">
        <div class="p-5">
            <h1 class="text-center">Nhà cung cấp</h2>
        </div>
        <div>
            <a href="../supplier_control/supplier_form.php" class="btn btn-success mb-1" style="padding:7px 40px">Thêm</a>
        </div>
        <div>
            <table class="table table-hover" id="tab">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tbo">
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function loadData(data) {
            // tạo một hàng mới
            for (var i = 0; i < data.length; i++) {
                var newRow = "<tr>";
                newRow += "<td>" + data[i].id + "</td>";
                newRow += "<td>" + data[i].name + "</td>";
                newRow += "<td>" + data[i].address + "</td>";
                newRow += "<td>" + data[i].phone + "</td>";
                newRow += "<td>" + data[i].email + "</td>";
                newRow += '<td>' +
                    '<a href="../supplier_control/supplier_form.php?id=' + data[i].id + '" class="text-success">' +
                    '<i class="fa-solid fa-pen-to-square fs-5 mx-1"></i>' +
                    '</a>' +
                    '<a href="#" class="text-secondary" name="btnDel" >' +
                    '<i class="fa-solid fa-trash fs-5 mx-1"></i>' +
                    '</a>' +
                    '</td>';
                newRow += "</tr>";
                $("#tbo").append(newRow);
            }
        }

        function getData() {
            $.ajax({
                type: "GET",
                url: "../supplier_control/supplier_data.php",
                dataType: "json",
                success: function(response) {
                    // Xử lý dữ liệu nhận được thành công
                    loadData(response);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu có
                    console.error(xhr.responseText);
                }
            });
        }

        function del() {
            $("#tbo").on("click", "a[name='btnDel']", function() {
                var ale = confirm("Bạn có muốn xóa");
                if (ale === true) {
                    var id = $(this).closest("tr").find("td:eq(0)").text(); // lấy id từ cột đầu tiên
                    $.ajax({
                        type: "POST",
                        url: "../supplier_control/supplier_del.php",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                    // // xóa hàng
                    var row = $(this).closest("tr");
                    row.remove();
                } else {}
            });
        }

        $(document).ready(function() {
            getData();
            del();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>