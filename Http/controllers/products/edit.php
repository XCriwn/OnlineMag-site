<?php

use database\Response;

$db = \core\App::resolve(\database\Database::class);

authorize(getCurrentUserRole() === 'admin');

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