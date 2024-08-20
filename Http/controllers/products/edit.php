<?php

use database\Response;

$db = \core\App::resolve(\database\Database::class);
//TODO product stuff

authorize(getCurrentUserRole() === 'admin');

//$product = $db->query("select * from product where id = :id", [
//    'id'=>$_GET['id']
//])->findOrFail(Response::NOT_FOUND);

//todo we want to take from the database what categories we already have for this product id
//todo and we want to put them in the selected-categories field

$product = $db->query("SELECT 
product.*, 
    GROUP_CONCAT(categories.name SEPARATOR ', ') AS category_names
FROM 
    product
LEFT JOIN 
    product_categories ON product.id = product_categories.product_id
LEFT JOIN 
    categories ON product_categories.category_id = categories.id
WHERE
    product.id = :id",[
        "id" => $_GET['id']
])->findOrFail(Response::NOT_FOUND);

view('products/edit.view.php', [
    'errors' => [],
    'header' => 'Edit Product',
    'product' => $product,
    'categories' => getAllCategories()
]);