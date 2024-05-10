<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.css">
</head>
<body>
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <script src="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.js"></script>
    <?php
        require('../components/header.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
        $database = new Database();
        if(isset($_GET['index'])){
            $indexValue = $_GET['index'];
        } else {
            $indexValue = '1';
        }
        $query_line_chart = '';
        if($indexValue == '1'){
            $query_line_chart = "SELECT DATE(paymentDate) AS day, SUM(total) AS quantity FROM payment WHERE paymentDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY) GROUP BY DATE(paymentDate)";
        } elseif ($indexValue == '2') {
            $query_line_chart = "SELECT DATE_FORMAT(paymentDate, '%Y-%m') AS day, SUM(total) AS quantity FROM payment WHERE paymentDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(paymentDate, '%Y-%m')";
        } elseif ($indexValue == '3') {
            $query_line_chart = "SELECT YEAR(paymentDate) AS day, SUM(total) AS quantity FROM payment WHERE paymentDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR) GROUP BY YEAR(paymentDate)";
        }
        $result_line_chart = $database->query($query_line_chart);
        $data_line_chart = [];
        while ($row = $result_line_chart->fetch_assoc()) {
            $data_line_chart[] = [$row['day'], $row['quantity']];
        }

        $result_pie_chart = $database->query("SELECT p.name AS product_name, p.image AS product_image, SUM(ol.quantity) AS total_quantity_sold FROM orderline ol JOIN product p ON ol.productId = p.id GROUP BY p.name ORDER BY total_quantity_sold DESC LIMIT 4");
        $data_pie_chart = [];
        while ($row = $result_pie_chart->fetch_assoc()) {
            $data_pie_chart[] = [$row['product_name'], $row['product_image'],$row['total_quantity_sold']];
        }
        $database->close();
    ?>
    <div class="container" style="margin-top: 150px;">
    <h1 class="fs-1 text-center">THỐNG KÊ</h1>
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-sm"><a href="?param=1" class="text-white text-decoration-none">Doanh thu</a></button>
            <button type="button" class="btn btn-primary btn-sm"><a href="?param=2" class="text-white text-decoration-none">Sản phẩm</a></button>
        </div>
        <div id="date"></div>
        <div id="line-chart"></div>
        <div id="top-product" class="row"></div>
        <div id="pie-chart"></div>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const paramValue = urlParams.get('param');
        var data_line_chart = <?php echo json_encode($data_line_chart); ?>;
        var data_pie_chart = <?php echo json_encode($data_pie_chart); ?>;
        function onSelectChange() {
            var selectElement = document.getElementById('mySelect');
            var selectedValue = selectElement.value;
            var currentUrl = window.location.href;
            currentUrl = removeIndexParams(currentUrl);
            var separator = currentUrl.indexOf('?') !== -1 ? '&' : '?';
            window.location.href = currentUrl + separator + 'index=' + selectedValue;
        }
        if (paramValue === null || paramValue === undefined) {
            paramValue = '1';
        }
        if (paramValue === '1') {
            var selectHTML = '<select class="mb-4" id="mySelect" onchange="onSelectChange()">' +
                                '<option value="1" <?php if($indexValue === '1') echo 'selected'; ?>>Tuần qua</option>' +
                                '<option value="2" <?php if($indexValue === '2') echo 'selected'; ?>>Tháng qua</option>' +
                                '<option value="3" <?php if($indexValue === '3') echo 'selected'; ?>>Năm qua</option>' +
                            '</select>';
            document.getElementById('date').innerHTML = selectHTML;
            bb.generate({
                bindto: "#line-chart",
                data: {
                    x: "x",
                    columns: [
                        ['x'].concat(data_line_chart.map(item => item[0])),
                        ['Revenue'].concat(data_line_chart.map(item => item[1]))
                    ],
                    types: {
                        Revenue: "area-spline"
                    }
                },
                axis: {
                    x: {
                        type: "timeseries",
                        tick: {
                            format: "%m/%d"
                        }
                    }
                },
            });
        } 
        if (paramValue === '2') {
            var div = '';
            for (var i = 0; i < data_pie_chart.length; i++) {
                var productName = data_pie_chart[i][0];
                var productImage = data_pie_chart[i][1];
                var totalQuantitySold = data_pie_chart[i][2];
                rank = i+1;
                div += '<div class="card col-md-3 my-4" style="width: 18rem;">' +
                    '<p class="text-center fs-1 border-bottom">Top '+rank+'</p>'+
                    '<img src="' + productImage + '" class="card-img-top" alt="' + productName + '">' +
                    '<div class="card-body">' +
                    '<h5 class="card-title">' + productName + '</h5>' +
                    '<p class="card-text">Total quantity sold: ' + totalQuantitySold + '</p>' +
                    '</div>' +
                    '</div>';
            }
            document.getElementById('top-product').innerHTML = div;
            bb.generate({
                bindto: "#pie-chart",
                data: {
                    columns: data_pie_chart,
                    type: "pie",
                },
            });
        }
        
        function removeIndexParams(url) {
            var urlParts = url.split('?');
            if (urlParts.length > 1) {
                var baseUrl = urlParts[0];
                var params = urlParts[1].split('&');
                var filteredParams = params.filter(function(param) {
                    return !param.startsWith('index=');
                });
                return baseUrl + '?' + filteredParams.join('&');
            } else {
                return url;
            }
        }
    </script>
    <div class="footer">
        <div class="footerleft">
        <?php require ("../components/footer.php");?>
        </div>
    </div>
</body>
</html> 
