<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/e-commerce-site/db_connect.php');
    function load_categories(){
        $database = new Database();
        $categories = $database->query("SELECT * FROM category");
        $number = 1;
        while ($row = $categories->fetch_assoc()){
            ?>
            <li class="danhmuc" onmouseenter="thaydoi1(<?=$number?>) " onmouseleave="thaydoi2(<?=$number?>)" ><a class="text-dark text-decoration-none fw-bold"><?=$row['category_name']?><i class="fa-solid fa-chevron-down" id="thaydoiicon<?=$number?>"></i></a>
                <ul class="item">
                    <?php load_subcategory($row['id'])?>
                </ul>
            </li>
            <?php
            $number+=1;
        }
        $database->close();
    }

    function load_subcategory($id){
        $database = new Database();
        $sub_category = $database->query("SELECT * FROM subcategory WHERE categoryId = ".$id);
        while($row = $sub_category->fetch_assoc()){?>
            <li><a href="/e-commerce-site/pages/product_category.php?subcategoryId=<?=$row['id']?>&subcategoryName=<?=$row['name']?>" class="text-dark text-decoration-none"><?=$row['name']?></a></li>
        <?php
        }
    }
?>