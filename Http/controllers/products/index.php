<?php

//authorize(getCurrentUserRole() !== NULL);


$db = \core\App::resolve(\database\Database::class);

$query = "SELECT 
product.*, 
    GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names
FROM 
    product
LEFT JOIN 
    product_categories ON product.id = product_categories.product_id
LEFT JOIN 
    categories ON product_categories.category_id = categories.id ";

$parameters = [];
if(!empty($_POST)) {

    $and = 0;

    if (!empty($_POST['filter_name'])) {
        $query = $query . "WHERE ";
        $query = $query . "product.name LIKE :product_name ";
        $parameters["product_name"] = '%' . $_POST["filter_name"] . '%';

        $and = 1;
    }

    if(!empty($_POST['filter_price_min'])) {
        if($and === 1) {$query = $query . "AND ";} else {$query = $query . "WHERE ";}
        $query = $query . "product.price >= :product_price_min ";
        $parameters["product_price_min"] = $_POST["filter_price_min"];
        $and = 1;
    }

    if(!empty($_POST['filter_price_max'])) {
        if($and === 1) {$query = $query . "AND ";} else {$query = $query . "WHERE ";}
        $query = $query . "product.price <= :product_price_max ";
        $parameters["product_price_max"] = $_POST['filter_price_max'];
        $and = 1;
    }
    if($_POST['filter_category'] !== "0") {
        \core\Session::flash("index_products_filter", 1);
        if($and === 1) {$query = $query . "AND ";} else {$query = $query . "WHERE ";}
        $query = $query . "product_categories.category_id = :product_category ";
        $parameters["product_category"] = $_POST['filter_category'];
        $and = 1;
    }
    else{
        \core\Session::flash("index_products_filter", 0);
    }
}
else{
    \core\Session::flash("index_products_filter", 0);
}

$query = $query . "GROUP BY product.id;";

\core\Session::flash("old_post", $_POST);
$products = $db->query($query, $parameters)->findAll();

view('products/index.view.php', [
    'products' => $products,
    'header' => 'All Products',
    'categories' => getAllCategories()
]);