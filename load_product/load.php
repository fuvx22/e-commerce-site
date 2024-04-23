<?php
    require_once("./db_connect.php");
    
    function load_products($subcategory){
        $database = new Database();
        $products = $database->query("SELECT * FROM product WHERE subcategoryId = " . $subcategory . " LIMIT 8");
        while($row = $products->fetch_assoc()){
            $image = $row['image'];
            $new_image = str_replace('../uploads/', './uploads/', $image);?>
            <a href="./pages/product_details.php?id=<?=$row['id']?>" style="text-decoration: none;">
                <img src="<?=$new_image?>" alt="" height="300px" width="20%">
            </a>
        <?php }
    }
?>