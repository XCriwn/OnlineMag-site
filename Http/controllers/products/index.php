<?php

authorize(getCurrentUserRole() !== NULL);


$db = \core\App::resolve(\database\Database::class);
//TODO check everything here and category

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


//$parameters["name"] = "Red Rose";
//$parameters["price"] = "130";

//if(!empty($_POST)) dd($_POST); var_dump($parameters);

if(!empty($_POST)){
    $and = 0;
    //todo we add a bit of query with just the where
    $query = $query . "WHERE ";

    if (!empty($_POST['filter_name'])) {
        // Modify the query to use LIKE instead of equals
        $query = $query . "product.name LIKE :product_name ";

        // Add wildcard characters to the parameter for pattern matching
        $parameters["product_name"] = '%' . $_POST["filter_name"] . '%';

        $and = 1;
    }

    if(!empty($_POST['filter_price_min'])){
        //todo for each $_post filter we add another bit of query and a bit of parameters
        if($and === 1) {$query = $query . "AND ";}
        $query = $query . "product.price >= :product_price_min ";
        $parameters["product_price_min"] = $_POST["filter_price_min"];
        $and = 1;
    }

    if(!empty($_POST['filter_price_max'])){
        //todo for each $_post filter we add another bit of query and a bit of parameters
        if($and === 1) {$query = $query . "AND ";}
        $query = $query . "product.price <= :product_price_max ";
        $parameters["product_price_max"] = $_POST['filter_price_max'];
        $and = 1;
    }
    //todo category
    if($_POST['filter_category'] !== "0"){
        //todo for each $_post filter we add another bit of query and a bit of parameters
        if($and === 1) {$query = $query . "AND ";}
        $query = $query . "product_categories.category_id = :product_category ";
        $parameters["product_category"] = $_POST['filter_category'];
        $and = 1;
    }



}
//dd($query);

$query = $query . "GROUP BY product.id;";

\core\Session::flash("old_post", $_POST);
//dd(\core\Session::getArrayKey("old_post", "filter_name"));

$products = $db->query($query, $parameters)->findAll();

view('products/index.view.php', [
    'products' => $products,
    'header' => 'All Products',
    'categories' => getAllCategories()
]);